<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    // Menampilkan halaman scanner
    public function index()
    {
        return view('scan.index');
    }

    // Proses QR Code
    public function process(Request $request)
    {
        $request->validate([
            'qr_token' => 'required|string'
        ]);

        $token = $request->qr_token;
        
        // Cari berdasarkan qr_token ATAU employee_code (Input Manual)
        $user = User::where(function($query) use ($token) {
            $query->where('qr_token', $token)
                  ->orWhere('employee_code', $token);
        })->with('shift')->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'QR Code tidak dikenali!'
            ], 404);
        }

        // Cek Role Owner
        if ($user->role === 'owner') {
            return response()->json([
                'status' => 'error',
                'message' => 'Halo Bos! Owner tidak perlu absen ya.'
            ], 403);
        }

        $today = Carbon::today();
        
        // Cek absensi hari ini
        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->first();

        $action = '';
        $time = Carbon::now()->format('H:i');
        $now = Carbon::now();

        if (!$attendance) {
            // CLOCK IN LOGIC
            if ($user->shift) {
                $shiftStart = Carbon::parse($user->shift->start_time)->setDate($now->year, $now->month, $now->day);
                
                // Allow clock in 30 minutes before shift starts
                $earliestClockIn = $shiftStart->copy()->subMinutes(30);

                if ($now->lessThan($earliestClockIn)) {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Terlalu pagi, {$user->name}! Absen masuk baru bisa dilakukan mulai pukul " . $earliestClockIn->format('H:i') . "."
                    ], 403);
                }

                // Check Late Status
                $status = 'present';
                $note = null;
                $lateThreshold = $shiftStart->copy()->addMinutes(15);

                if ($now->greaterThan($lateThreshold)) {
                    $status = 'late';
                    $minutesLate = $now->diffInMinutes($shiftStart);
                    $note = "Terlambat {$minutesLate} menit";
                }

                // Clock In
                Attendance::create([
                    'user_id' => $user->id,
                    'clock_in' => $now,
                    'status' => $status,
                    'note' => $note
                ]);
                
                $action = 'Masuk';
                $statusText = $status === 'late' ? 'TERLAMBAT' : 'TEPAT WAKTU';
                $message = "Halo, {$user->name}! Absen MASUK berhasil pukul {$time} ({$statusText}).";
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => "Pegawai {$user->name} belum memiliki shift. Hubungi Admin."
                ], 403);
            }
        
        } elseif (!$attendance->clock_out) {
            // CLOCK OUT LOGIC
            if ($user->shift) {
                $shiftEnd = Carbon::parse($user->shift->end_time)->setDate($now->year, $now->month, $now->day);

                // Handle shift that ends past midnight (e.g., Malam 23:00 - 07:00)
                if ($shiftEnd->lessThan($attendance->clock_in)) {
                    $shiftEnd->addDay();
                }

                if ($now->lessThan($shiftEnd)) {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Belum waktunya pulang, {$user->name}! Shift Anda berakhir pukul " . $shiftEnd->format('H:i') . "."
                    ], 403);
                }
            }

            $attendance->update([
                'clock_out' => Carbon::now()
            ]);
            $action = 'Pulang';
            $message = "Sampai jumpa, {$user->name}! Absen PULANG berhasil pukul {$time}.";
        } else {
            return response()->json([
                'status' => 'warning',
                'message' => "Halo {$user->name}, Anda sudah menyelesaikan shift hari ini."
            ]);
        }

        return response()->json([
            'status' => 'success',
            'action' => $action,
            'user_name' => $user->name,
            'time' => $time,
            'message' => $message
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function myQr()
    {
        $employee = auth()->user();
        return view('admin.employees.print-card', compact('employee'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today();

        // Cek absensi hari ini
        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->first();

        if (!$attendance) {
            // CLOCK IN
            Attendance::create([
                'user_id' => $user->id,
                'clock_in' => Carbon::now(),
                'status' => 'present',
            ]);
            return redirect()->back()->with('success', 'Halo ' . $user->name . '! Absen masuk berhasil.');
        } elseif (!$attendance->clock_out && $attendance->status == 'present') {
            // CLOCK OUT (Only if status is present)
            $attendance->update([
                'clock_out' => Carbon::now(),
            ]);
            return redirect()->back()->with('success', 'Sampai jumpa! Absen pulang berhasil dicatat.');
        } else {
            return redirect()->back()->with('info', 'Anda sudah menyelesaikan shift hari ini atau sedang izin.');
        }
    }

    public function createLeave()
    {
        return view('attendance.leave');
    }

    public function submitLeave(Request $request)
    {
        $request->validate([
            'status' => 'required|in:sick,permit',
            'note' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $user = Auth::user();
        $today = Carbon::today();

        // Cek apakah sudah absen hari ini
        $existing = Attendance::where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Anda sudah melakukan absensi atau mengajukan izin hari ini.');
        }

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments', 'public');
        }

        Attendance::create([
            'user_id' => $user->id,
            'status' => $request->status,
            'note' => $request->note,
            'attachment' => $path,
            'clock_in' => null, // Tidak ada clock in
            'is_approved' => null, // Pending
        ]);

        return redirect()->back()->with('success', 'Pengajuan izin berhasil dikirim. Menunggu persetujuan Owner.');
    }
}
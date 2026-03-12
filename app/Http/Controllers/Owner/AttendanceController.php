<?php

namespace App\Http\Controllers\Owner;



use App\Http\Controllers\Controller;

use App\Models\Attendance;

use App\Models\User;

use Carbon\Carbon;

use Illuminate\Http\Request;



class AttendanceController extends Controller

{

        public function index()

        {

            // Gunakan timezone lokal (Asia/Jakarta)

            $today = Carbon::today(); // 00:00:00 hari ini

    

            // Statistik Card (Realtime Hari Ini)

            $stats = [

                'present' => Attendance::whereDate('created_at', $today)

                    ->whereIn('status', ['present', 'late'])

                    ->count(),

                

                'late' => Attendance::whereDate('created_at', $today)

                    ->where('status', 'late')

                    ->count(),

                

                'pending' => Attendance::whereIn('status', ['sick', 'permit']) // Pending dihitung total (bukan per hari) agar tidak terlewat

                    ->whereNull('is_approved')

                    ->count(),

                

                'employees' => User::whereIn('role', ['admin', 'cashier'])

                    ->where('is_active', true)

                    ->count()

            ];

        $attendances = Attendance::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('owner.attendance.index', compact('attendances', 'stats'));
    }

    public function approve(Attendance $attendance)
    {
        $attendance->update([
            'is_approved' => true
        ]);

        return redirect()->back()->with('success', 'Izin berhasil disetujui.');
    }

    public function reject(Attendance $attendance)
    {
        $attendance->update([
            'is_approved' => false
        ]);

        return redirect()->back()->with('warning', 'Izin ditolak.');
    }
}
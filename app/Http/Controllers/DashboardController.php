<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user && $user->isOwner()) {
            return redirect()->route('owner.dashboard');
        }

        $today = Carbon::today();

        // Cek absensi user hari ini
        $todayAttendance = null;
        if($user) {
            $todayAttendance = Attendance::where('user_id', $user->id)
                ->whereDate('created_at', $today)
                ->first();
        }

        // 1. Hitung Omzet Hari Ini
        $todaysIncome = Transaction::whereDate('created_at', $today)->sum('total_price');

        // 2. Hitung Jumlah Transaksi Hari Ini
        $todaysCount = Transaction::whereDate('created_at', $today)->count();

        // 3. Cari Barang yang Stoknya Sedikit (< 5)
        $lowStockProducts = Product::where('stock', '<', 5)->get();

        return view('dashboard', compact('todaysIncome', 'todaysCount', 'lowStockProducts', 'todayAttendance'));
    }
}
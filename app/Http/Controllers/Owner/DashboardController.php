<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();

        // 1. Statistik Utama
        $todaySales = Transaction::whereDate('created_at', $today)->sum('total_price');
        $todayTransactions = Transaction::whereDate('created_at', $today)->count();
        $monthSales = Transaction::whereBetween('created_at', [$startOfMonth, Carbon::now()])->sum('total_price');
        
        // 2. Notifikasi & Operasional
        $lowStockProducts = Product::where('stock', '<', 10)->count();
        $presentEmployees = Attendance::whereDate('created_at', $today)
            ->where('status', 'present')
            ->count();
        
        // Detailed Leave Stats
        $pendingLeaves = Attendance::whereIn('status', ['sick', 'permit'])
            ->whereNull('is_approved')
            ->count();
        $approvedLeaves = Attendance::whereIn('status', ['sick', 'permit'])
            ->where('is_approved', true)
            ->count();
        $rejectedLeaves = Attendance::whereIn('status', ['sick', 'permit'])
            ->where('is_approved', false)
            ->count();

        // 3. Grafik Penjualan 7 Hari Terakhir
        $chartData = [];
        $chartLabels = [];
        
        $salesData = Transaction::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_price) as total')
            )
            ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->get()
            ->pluck('total', 'date');

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $displayDate = Carbon::now()->subDays($i)->format('d M');
            
            $chartLabels[] = $displayDate;
            $chartData[] = $salesData[$date] ?? 0;
        }

        // 4. Produk Terlaris (Top 5 Bulan Ini)
        $topProducts = TransactionDetail::select('product_id', DB::raw('sum(quantity) as total_qty'))
            ->whereHas('transaction', function($q) use ($startOfMonth) {
                $q->where('created_at', '>=', $startOfMonth);
            })
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        // 5. Transaksi Terbaru
        $recentTransactions = Transaction::latest()->limit(5)->with('user')->get();

        return view('owner.dashboard', compact(
            'todaySales',
            'todayTransactions',
            'monthSales',
            'lowStockProducts',
            'presentEmployees',
            'pendingLeaves',
            'approvedLeaves',
            'rejectedLeaves',
            'chartLabels',
            'chartData',
            'topProducts',
            'recentTransactions'
        ));
    }
}
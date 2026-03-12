<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function financial(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        $transactions = Transaction::with(['user', 'details'])
            ->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ])
            ->latest()
            ->get();

        $totalRevenue = $transactions->sum('total_price');
        $totalProfit = 0; // If we had modal price, we could calculate profit. For now, assume simple revenue.

        return view('owner.reports.financial', compact('transactions', 'totalRevenue', 'startDate', 'endDate'));
    }

    public function products()
    {
        $products = Product::with('category')
            ->orderBy('stock', 'asc') // Show low stock first
            ->get();

        return view('owner.reports.products', compact('products'));
    }
}
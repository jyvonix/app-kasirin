<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Exports\FinancialExport;
use App\Exports\ProductExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function financial(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        $transactions = $this->getFinancialData($startDate, $endDate);
        $totalRevenue = $transactions->sum('total_price');

        return view('owner.reports.financial', compact('transactions', 'totalRevenue', 'startDate', 'endDate'));
    }

    private function getFinancialData($startDate, $endDate)
    {
        return Transaction::with(['user', 'details'])
            ->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ])
            ->latest()
            ->get();
    }

    public function exportFinancialExcel(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $transactions = $this->getFinancialData($startDate, $endDate);

        return Excel::download(new FinancialExport($transactions), 'Laporan-Keuangan-' . $startDate . '-to-' . $endDate . '.xlsx');
    }

    public function exportFinancialPdf(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $transactions = $this->getFinancialData($startDate, $endDate);
        $totalRevenue = $transactions->sum('total_price');

        $pdf = Pdf::loadView('owner.reports.pdf.financial', compact('transactions', 'totalRevenue', 'startDate', 'endDate'));
        return $pdf->download('Laporan-Keuangan-' . $startDate . '-to-' . $endDate . '.pdf');
    }

    public function products()
    {
        $products = Product::with('category')
            ->orderBy('stock', 'asc')
            ->get();

        return view('owner.reports.products', compact('products'));
    }

    public function exportProductExcel()
    {
        $products = Product::with('category')->get();
        return Excel::download(new ProductExport($products), 'Laporan-Stok-Produk.xlsx');
    }

    public function exportProductPdf()
    {
        $products = Product::with('category')->get();
        $pdf = Pdf::loadView('owner.reports.pdf.product', compact('products'));
        return $pdf->download('Laporan-Stok-Produk.pdf');
    }
}
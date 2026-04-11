<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class FinancialExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        return $this->transactions;
    }

    public function headings(): array
    {
        return [
            'Invoice',
            'Tanggal',
            'Kasir',
            'Subtotal',
            'Diskon',
            'Pajak',
            'Total',
            'Metode',
            'Status'
        ];
    }

    public function map($trx): array
    {
        return [
            $trx->invoice_code,
            $trx->created_at->format('d/m/Y H:i'),
            $trx->user ? $trx->user->name : 'Unknown',
            $trx->subtotal,
            $trx->discount_amount,
            $trx->tax_amount,
            $trx->total_price,
            strtoupper($trx->payment_type),
            strtoupper($trx->payment_status),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

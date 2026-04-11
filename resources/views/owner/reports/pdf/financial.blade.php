<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan Kasirin</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; font-size: 12px; margin: 0; padding: 0; }
        .header { text-align: center; padding: 20px; border-bottom: 2px solid #4f46e5; }
        .header h1 { margin: 0; color: #4f46e5; font-size: 24px; }
        .header p { margin: 5px 0; color: #666; }
        .content { padding: 20px; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 5px 0; }
        .main-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .main-table th { background-color: #4f46e5; color: white; padding: 10px; text-align: left; }
        .main-table td { padding: 10px; border-bottom: 1px solid #eee; }
        .main-table tr:nth-child(even) { background-color: #f9fafb; }
        .total-section { margin-top: 20px; text-align: right; padding: 20px; background-color: #f3f4f6; border-radius: 10px; }
        .total-section h2 { margin: 0; color: #4f46e5; }
        .footer { position: fixed; bottom: 20px; left: 0; right: 0; text-align: center; color: #999; font-size: 10px; }
        .badge { padding: 3px 8px; border-radius: 5px; font-size: 10px; font-bold: true; }
        .badge-success { background-color: #d1fae5; color: #065f46; }
        .badge-pending { background-color: #fef3c7; color: #92400e; }
    </style>
</head>
<body>
    <div class="header">
        <h1>KASIRIN PRO SYSTEM</h1>
        <p>Laporan Pendapatan Keuangan</p>
        <p style="font-size: 10px; color: #999;">Periode: {{ $startDate }} s/d {{ $endDate }}</p>
    </div>

    <div class="content">
        <table class="info-table">
            <tr>
                <td width="50%"><strong>Dicetak Oleh:</strong> {{ auth()->user()->name }}</td>
                <td width="50%" align="right"><strong>Tanggal Cetak:</strong> {{ date('d/m/Y H:i') }}</td>
            </tr>
        </table>

        <table class="main-table">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Waktu</th>
                    <th>Kasir</th>
                    <th>Total</th>
                    <th>Metode</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $trx)
                <tr>
                    <td><strong>{{ $trx->invoice_code }}</strong></td>
                    <td>{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $trx->user ? $trx->user->name : '-' }}</td>
                    <td>Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                    <td>{{ strtoupper($trx->payment_type) }}</td>
                    <td>
                        <span class="badge {{ $trx->payment_status == 'paid' ? 'badge-success' : 'badge-pending' }}">
                            {{ strtoupper($trx->payment_status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <p style="margin-bottom: 5px; color: #666;">Total Transaksi: {{ $transactions->count() }}</p>
            <h2>Total Pendapatan: Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
        </div>
    </div>

    <div class="footer">
        Laporan ini dihasilkan secara otomatis oleh Sistem Kasirin.
    </div>
</body>
</html>

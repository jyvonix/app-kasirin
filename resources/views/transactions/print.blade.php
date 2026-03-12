<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ $transaction->invoice_code }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            margin: 0;
            padding: 10px;
            width: 58mm; /* Sesuaikan dgn printer thermal */
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 5px;
        }
        .shop-name {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .meta {
            font-size: 10px;
            margin-bottom: 5px;
        }
        .items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .items th {
            text-align: left;
            border-bottom: 1px solid #000;
        }
        .items td {
            padding: 2px 0;
            vertical-align: top;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .totals {
            width: 100%;
            margin-top: 5px;
            border-top: 1px dashed #000;
            padding-top: 5px;
        }
        .grand-total {
            font-weight: bold;
            font-size: 14px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
        }
        
        @media print {
            body { margin: 0; padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <div class="shop-name">{{ $shopName }}</div>
        <div>{{ $shopAddress }}</div>
    </div>

    <div class="meta">
        <div>No: {{ $transaction->invoice_code }}</div>
        <div>Tgl: {{ $transaction->created_at->format('d/m/Y H:i') }}</div>
        <div>Kasir: {{ $transaction->user->name }}</div>
    </div>

    <table class="items">
        <thead>
            <tr>
                <th style="width: 40%">Item</th>
                <th style="width: 20%" class="text-right">Qty</th>
                <th style="width: 40%" class="text-right">Sub</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaction->details as $detail)
            <tr>
                <td colspan="3">{{ $detail->product->name }}</td>
            </tr>
            <tr>
                <td></td>
                <td class="text-right">{{ $detail->quantity }} x {{ number_format($detail->price, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td>Subtotal</td>
            <td class="text-right">{{ number_format($transaction->subtotal, 0, ',', '.') }}</td>
        </tr>
        @if($transaction->discount_amount > 0)
        <tr>
            <td>Diskon</td>
            <td class="text-right">-{{ number_format($transaction->discount_amount, 0, ',', '.') }}</td>
        </tr>
        @if($transaction->voucher)
        <tr>
            <td colspan="2" style="font-size: 10px; font-style: italic;">(Kode: {{ $transaction->voucher->code }})</td>
        </tr>
        @endif
        @endif
        @if($transaction->tax_amount > 0)
        <tr>
            <td>PPN</td>
            <td class="text-right">{{ number_format($transaction->tax_amount, 0, ',', '.') }}</td>
        </tr>
        @endif
        <tr class="grand-total">
            <td>TOTAL</td>
            <td class="text-right">{{ number_format($transaction->total_price, 0, ',', '.') }}</td>
        </tr>
        
        @if($transaction->payment_type == 'cash')
        <tr>
            <td>Tunai</td>
            <td class="text-right">{{ number_format($transaction->cash_amount, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Kembali</td>
            <td class="text-right">{{ number_format($transaction->change_amount, 0, ',', '.') }}</td>
        </tr>
        @else
        <tr>
            <td>Metode</td>
            <td class="text-right uppercase">{{ $transaction->payment_type }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td class="text-right uppercase">{{ $transaction->payment_status }}</td>
        </tr>
        @endif
    </table>

    <div class="footer">
        <p>Terima Kasih atas Kunjungan Anda!</p>
        <p>Barang yang sudah dibeli tidak dapat ditukar/dikembalikan.</p>
    </div>
</body>
</html>

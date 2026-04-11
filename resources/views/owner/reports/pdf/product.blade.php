<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Stok Produk Kasirin</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; font-size: 12px; margin: 0; padding: 0; }
        .header { text-align: center; padding: 20px; border-bottom: 2px solid #00d5c3; }
        .header h1 { margin: 0; color: #4c3494; font-size: 24px; }
        .header p { margin: 5px 0; color: #666; }
        .content { padding: 20px; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 5px 0; }
        .main-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .main-table th { background-color: #4c3494; color: white; padding: 10px; text-align: left; }
        .main-table td { padding: 10px; border-bottom: 1px solid #eee; }
        .main-table tr:nth-child(even) { background-color: #f9fafb; }
        .footer { position: fixed; bottom: 20px; left: 0; right: 0; text-align: center; color: #999; font-size: 10px; }
        .badge { padding: 3px 8px; border-radius: 5px; font-size: 10px; font-bold: true; }
        .badge-danger { background-color: #fee2e2; color: #991b1b; }
        .badge-success { background-color: #d1fae5; color: #065f46; }
    </style>
</head>
<body>
    <div class="header">
        <h1>KASIRIN PRO SYSTEM</h1>
        <p>Laporan Stok & Inventori Produk</p>
    </div>

    <div class="content">
        <table class="info-table">
            <tr>
                <td width="50%"><strong>Dicetak Oleh:</strong> {{ auth()->user()->name }}</td>
                <td width="50%" align="right"><strong>Tanggal:</strong> {{ date('d/m/Y H:i') }}</td>
            </tr>
        </table>

        <table class="main-table">
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td><span style="font-family: monospace;">{{ $product->sku }}</span></td>
                    <td><strong>{{ $product->name }}</strong></td>
                    <td>{{ $product->category ? $product->category->name : 'N/A' }}</td>
                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        @if($product->stock <= 5)
                            <span class="badge badge-danger">STOK RENDAH</span>
                        @else
                            <span class="badge badge-success">AMAN</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        Laporan stok barang dicetak pada {{ date('d/m/Y H:i') }}. Harap segera re-stock untuk item dengan status STOK RENDAH.
    </div>
</body>
</html>

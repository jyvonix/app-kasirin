<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    // IZINKAN KOLOM INI DIISI:
    protected $fillable = [
        'transaction_id',
        'product_id',
        'quantity',
        'price'
    ];

    // Relasi balik ke Produk
    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    // Relasi ke Transaksi Utama
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
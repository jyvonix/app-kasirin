<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'voucher_id',
        'invoice_code',
        'subtotal',
        'discount_amount',
        'tax_amount',
        'total_price',
        'cash_amount',
        'change_amount',
        'payment_type',
        'payment_status',
        'snap_token',
    ];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}

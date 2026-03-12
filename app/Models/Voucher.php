<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type', // 'fixed', 'percentage'
        'amount',
        'min_purchase_amount',
        'max_discount_amount',
        'quantity',
        'used_count',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'amount' => 'decimal:2',
        'min_purchase_amount' => 'decimal:2',
        'max_discount_amount' => 'decimal:2',
    ];

    /**
     * Check if voucher is valid for use.
     */
    public function isValidFor($purchaseAmount = 0)
    {
        if (!$this->is_active) {
            return false;
        }

        $now = Carbon::now();

        if ($this->start_date && $now->lt($this->start_date)) {
            return false;
        }

        if ($this->end_date && $now->gt($this->end_date)) {
            return false;
        }

        if ($this->quantity !== null && $this->used_count >= $this->quantity) {
            return false;
        }

        if ($purchaseAmount < $this->min_purchase_amount) {
            return false;
        }

        return true;
    }
    
    /**
     * Get status label for UI
     */
    public function getStatusLabelAttribute()
    {
        if (!$this->is_active) return 'Non-Aktif';
        
        $now = Carbon::now();
        
        if ($this->start_date && $now->lt($this->start_date)) return 'Belum Mulai';
        if ($this->end_date && $now->gt($this->end_date)) return 'Kadaluarsa';
        if ($this->quantity !== null && $this->used_count >= $this->quantity) return 'Habis';
        
        return 'Aktif';
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}

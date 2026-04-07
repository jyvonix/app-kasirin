<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    // Izinkan kolom-kolom ini diisi:
    protected $fillable = [
        'name', 
        'image', 
        'stock', 
        'price', 
        'barcode', 
        'category_id'
    ];

    // Relasi ke Category (Agar bisa panggil $product->category->name)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
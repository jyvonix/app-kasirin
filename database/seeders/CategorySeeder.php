<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Mie',
            'Beras',
            'Telur',
            'Terigu',
            'Minyak',
            'Minuman',
            'Snack',
            'Obat-obatan',
            'Bumbu Dapur',
            'Perlengkapan Mandi',
            'Rokok',
            'Lainnya'
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['name' => $cat]);
        }
    }
}
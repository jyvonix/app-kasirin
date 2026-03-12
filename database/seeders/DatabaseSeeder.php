<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin: Mengelola sistem & pegawai
        User::create([
            'name' => 'Admin Kasirin',
            'username' => 'admin',
            'email' => 'admin@kasirin.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Kasir: Mengelola transaksi
        User::create([
            'name' => 'Kasir Toko',
            'username' => 'kasir',
            'email' => 'kasir@kasirin.test',
            'password' => Hash::make('password'),
            'role' => 'cashier',
            'is_active' => true,
        ]);

        // Owner: Memantau laporan
        User::create([
            'name' => 'Owner Kasirin',
            'username' => 'owner',
            'email' => 'owner@kasirin.test',
            'password' => Hash::make('password'),
            'role' => 'owner',
            'is_active' => true,
        ]);
    }
}
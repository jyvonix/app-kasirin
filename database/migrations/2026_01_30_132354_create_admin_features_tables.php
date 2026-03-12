<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tabel Shifts (Jam Kerja)
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Pagi, Siang, Malam
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
        });

        // 2. Tabel Settings (Pajak, Nama Toko, dll)
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // tax_rate, shop_name
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // 3. Tambah kolom shift_id ke Users
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('shift_id')->nullable()->constrained('shifts')->nullOnDelete()->after('role');
        });

        // Seed Default Settings & Shift
        DB::table('shifts')->insert([
            ['name' => 'Shift Pagi', 'start_time' => '07:00:00', 'end_time' => '15:00:00'],
            ['name' => 'Shift Sore', 'start_time' => '15:00:00', 'end_time' => '23:00:00'],
        ]);

        DB::table('settings')->insert([
            ['key' => 'tax_rate', 'value' => '11'], // Pajak 11%
            ['key' => 'shop_name', 'value' => 'Kasirin Mart'],
            ['key' => 'shop_address', 'value' => 'Jl. Digital No. 1'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['shift_id']);
            $table->dropColumn('shift_id');
        });
        Schema::dropIfExists('settings');
        Schema::dropIfExists('shifts');
    }
};
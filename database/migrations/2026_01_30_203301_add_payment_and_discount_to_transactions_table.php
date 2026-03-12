<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('payment_type')->default('cash')->after('change_amount'); // cash, qris, gopay, etc
            $table->string('payment_status')->default('paid')->after('payment_type'); // paid, pending, failed (Tunai default lgsg paid)
            $table->string('snap_token')->nullable()->after('payment_status'); // Token Midtrans
            $table->decimal('subtotal', 12, 2)->default(0)->after('invoice_code'); // Harga sebelum diskon/pajak
            $table->decimal('discount_amount', 12, 2)->default(0)->after('subtotal');
            $table->decimal('tax_amount', 12, 2)->default(0)->after('discount_amount');
            
            // Ubah cash_amount jadi nullable di masa depan jika perlu, tapi skrg kita biarkan
            // karena logic controller akan handle isi 0 jika non-tunai.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['payment_type', 'payment_status', 'snap_token', 'subtotal', 'discount_amount', 'tax_amount']);
        });
    }
};
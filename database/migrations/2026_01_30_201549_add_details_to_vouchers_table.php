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
        Schema::table('vouchers', function (Blueprint $table) {
            $table->decimal('min_purchase_amount', 12, 2)->default(0)->after('amount');
            $table->decimal('max_discount_amount', 12, 2)->nullable()->after('min_purchase_amount');
            $table->integer('used_count')->default(0)->after('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropColumn(['min_purchase_amount', 'max_discount_amount', 'used_count']);
        });
    }
};
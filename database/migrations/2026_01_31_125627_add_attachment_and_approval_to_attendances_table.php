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
        Schema::table('attendances', function (Blueprint $table) {
            $table->string('attachment')->nullable()->after('note'); // Bukti sakit/izin
            $table->boolean('is_approved')->default(false)->after('attachment'); // Status persetujuan owner
            // Make clock_in nullable because a leave request might be submitted before the day starts or without clocking in
            $table->timestamp('clock_in')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn(['attachment', 'is_approved']);
            $table->timestamp('clock_in')->nullable(false)->change();
        });
    }
};
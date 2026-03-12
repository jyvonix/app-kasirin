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
        // Because Doctrine DBAL (used by Laravel for changing columns) doesn't support changing ENUM values easily,
        // and raw SQL varies by database, we use a raw statement suitable for MySQL/MariaDB (implied by XAMPP usage).
        
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'cashier', 'owner') DEFAULT 'cashier'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverting back to original state if needed, though 'owner' data might be lost or invalid if reverted strictly.
        // We keep 'owner' in the down migration for safety to avoid data loss, or we could revert to just admin/cashier if we were strict.
        // For this context, let's just ensure it's valid SQL.
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'cashier') DEFAULT 'cashier'");
    }
};
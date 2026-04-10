<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan; // Tambahkan ini
// ... (keep other imports)

// --- EMERGENCY FIX: CLEAR CACHE & DEBUG MIDTRANS ---
Route::get('/debug-midtrans', function() {
    try {
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('cache:clear');
        
        return [
            'message' => 'Cache telah dibersihkan secara otomatis!',
            'config_is_production' => config('services.midtrans.is_production'),
            'midtrans_sdk_is_production' => \Midtrans\Config::$isProduction,
            'server_key_prefix' => substr(\Midtrans\Config::$serverKey, 0, 7) . '...',
            'server_key_empty' => empty(\Midtrans\Config::$serverKey),
            'app_env' => env('APP_ENV'),
        ];
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
});

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\SettingController;

use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Http\Controllers\Owner\ReportController as OwnerReportController;
use App\Http\Controllers\Owner\AttendanceController as OwnerAttendanceController;

use App\Http\Controllers\ScanController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/my-qr', [AttendanceController::class, 'myQr'])->name('attendance.my-qr');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/attendance/leave', [AttendanceController::class, 'createLeave'])->name('attendance.create'); // Form Izin
    Route::post('/attendance/leave', [AttendanceController::class, 'submitLeave'])->name('attendance.leave'); // Submit Izin

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- ADMIN ONLY AREA ---
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('vouchers', VoucherController::class)->except(['index']);
        Route::resource('products', ProductController::class);
        
        // Print Card Route (Must be above resource to avoid being caught by {employee} wildcard if it was a static path, 
        // but here it has a specific suffix so it's fine, but let's keep it clean)
        Route::get('employees/{employee}/print-card', [EmployeeController::class, 'printCard'])->name('employees.print-card');
        Route::resource('employees', EmployeeController::class);
        
        Route::resource('shifts', ShiftController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    });

    // --- OWNER AREA ---
    Route::middleware(['role:owner'])->prefix('owner')->name('owner.')->group(function () {
        Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');
        
        Route::get('/laporan/keuangan', [OwnerReportController::class, 'financial'])->name('reports.financial');
        Route::get('/laporan/produk', [OwnerReportController::class, 'products'])->name('reports.products');

        Route::get('/absensi', [OwnerAttendanceController::class, 'index'])->name('attendance.index');
        Route::patch('/absensi/{attendance}/approve', [OwnerAttendanceController::class, 'approve'])->name('attendance.approve');
        Route::patch('/absensi/{attendance}/reject', [OwnerAttendanceController::class, 'reject'])->name('attendance.reject');
    });

    // --- DEBUG MIDTRANS (CEK DI HOSTING) ---
    Route::get('/debug-midtrans', function() {
        return [
            'config_is_production' => config('services.midtrans.is_production'),
            'midtrans_sdk_is_production' => \Midtrans\Config::$isProduction,
            'server_key_prefix' => substr(\Midtrans\Config::$serverKey, 0, 7) . '...',
            'server_key_empty' => empty(\Midtrans\Config::$serverKey),
            'app_env' => env('APP_ENV'),
        ];
    });

    // --- FITUR SCANNER ABSENSI (MODERN) ---
    Route::get('/scan-absensi', [ScanController::class, 'index'])->name('scan.index');
    Route::post('/scan/process', [ScanController::class, 'process'])->name('scan.process');

    // --- CASHIER AREA ---
    Route::middleware(['role:cashier,admin'])->group(function () {
        // Shared Resources (Cashier only INDEX)
        Route::get('vouchers', [VoucherController::class, 'index'])->name('vouchers.index');

        // Main POS Page
        Route::get('/kasir', [TransactionController::class, 'index'])->name('kasir.index'); // Reverted to match views
        
        // API-like endpoints for POS JS
        Route::post('/kasir/bayar', [TransactionController::class, 'store'])->name('transactions.store');
        Route::get('/kasir/check-voucher', [TransactionController::class, 'checkVoucher'])->name('transactions.check_voucher');
        Route::post('/transactions/{transaction}/update-status', [TransactionController::class, 'updateStatus'])->name('transactions.update_status');
        Route::get('/transactions/{transaction}/print', [TransactionController::class, 'print'])->name('transactions.print');
    });

// --- REPORT & HISTORY AREA ---
    Route::get('/riwayat-transaksi', [TransactionController::class, 'history'])->name('transactions.history');
    Route::get('/riwayat-transaksi/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
});

require __DIR__.'/auth.php';

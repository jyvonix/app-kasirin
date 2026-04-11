<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Midtrans\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Pendaftaran manual untuk hosting (Fix Class Not Found)
        $this->app->register(\Maatwebsite\Excel\ExcelServiceProvider::class);
        $this->app->register(\Barryvdh\DomPDF\ServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Alias manual agar bisa dipanggil langsung di Controller/View
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Excel', \Maatwebsite\Excel\Facades\Excel::class);
        $loader->alias('Pdf', \Barryvdh\DomPDF\Facade\Pdf::class);

        // Konfigurasi Global Midtrans
        Config::$serverKey = trim((string) config('services.midtrans.server_key'));
        Config::$isProduction = (bool) config('services.midtrans.is_production');
        Config::$isSanitized = (bool) config('services.midtrans.is_sanitized');
        Config::$is3ds = (bool) config('services.midtrans.is_3ds');
    }
}

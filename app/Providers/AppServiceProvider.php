<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        // Ambil pengaturan dari database jika tabel ada
        if (Schema::hasTable('settings')) {
            $setting = Setting::pluck('value', 'key')->toArray();

            View::composer('*', function ($view) use ($setting) {
                $view->with('settings', $setting);
            });
        }

        // Gate untuk Super Admin
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        /**
         * Perbaikan untuk Intelephense (P1009):
         * Kita hapus type-hinting 'Money' yang bikin garis merah di editor,
         * karena library-nya kemungkinan tidak terinstall atau beda namespace.
         */
        if (class_exists('Money\Money')) {
            Lang::stringable(function ($money) {
                return method_exists($money, 'formatTo') ? $money->formatTo('en_GB') : (string) $money;
            });
        }
    }
}
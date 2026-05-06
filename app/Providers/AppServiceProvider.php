<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AladhanService;
use App\Services\QuranService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AladhanService::class);
        $this->app->singleton(QuranService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\OTPService;
use App\Models\Product;
use App\Observers\ProductObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(OTPService::class, function ($app) {
            return new OTPService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Product::observe(ProductObserver::class);
    }
}

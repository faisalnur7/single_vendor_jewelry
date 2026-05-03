<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Services\OTPService;
use App\Models\Product;
use App\Models\GeneralSetting;
use App\Models\ContactSetting;
use App\Models\SocialMediaSetting;
use App\Observers\ProductObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(OTPService::class, function ($app) {
            return new OTPService();
        });
    }

    public function boot(): void
    {
        Product::observe(ProductObserver::class);

        // Share cached settings with all views — eliminates raw Model::first() calls in Blade
        View::composer('*', function ($view) {
            $view->with('general_settings',    Cache::remember('general_settings',    3600, fn() => GeneralSetting::first()));
            $view->with('contact_settings',    Cache::remember('contact_settings',    3600, fn() => ContactSetting::first()));
            $view->with('social_media_settings', Cache::remember('social_media_settings', 3600, fn() => SocialMediaSetting::first()));
        });
    }
}

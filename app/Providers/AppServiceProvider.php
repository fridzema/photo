<?php

namespace App\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('cdn', function ($asset_path) {
            $cdn_url = env('CDN_URL', 'https:://static.fridzema.com');

            return (env('APP_ENV') == 'production') ? $cdn_url.$asset_path : asset($asset_path);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}

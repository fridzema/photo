<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;

use Session;
use Cache;

class LocaleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // $language = Session::get('language', Config::get('app.locale'));
        // App::setLocale($language);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // dd(Config::get('app.locale'));
      // dd(Session::get('language'));
      // $language = Session::get('language', Config::get('app.locale'));
      // \App::setLocale($language);
    }
}

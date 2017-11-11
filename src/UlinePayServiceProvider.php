<?php

namespace Ymstars\UlinePay;

use Illuminate\Support\ServiceProvider;
use Ymstars\UlinePay\Facades\UlineFacade;

class UlinePayServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/laravel-uline.php' => config_path('ulinepay.php'),
        ]);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->mergeConfigFrom(
            __DIR__ . '/config/laravel-uline.php', 'ulinepay'
        );

        $this->app->singleton('ulinepay', function () {
            return new UlinePay();
        });
    }
}
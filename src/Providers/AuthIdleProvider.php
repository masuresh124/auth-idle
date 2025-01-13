<?php

namespace Masuresh124\AuthIdle\Providers;

use Illuminate\Support\ServiceProvider;

class AuthIdleProvider extends ServiceProvider
{

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/auth-idle.php',
            'auth-idle'
        );

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $this->publishes([
            __DIR__ . '/../config/auth-idle.php' => config_path('auth-idle.php'),
        ], 'config-auth-idle');
        $this->publishes([
            __DIR__ . '/../js' => public_path('js'),
        ], 'js-auth-idle');

    }
}

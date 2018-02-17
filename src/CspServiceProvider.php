<?php

namespace Spatie\Csp;

use Spatie\Csp\Nonce\NonceGenerator;
use Illuminate\Support\ServiceProvider;

class CspServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/csp.php' => config_path('csp.php'),
            ], 'config');
        }

        $this->app->singleton(NonceGenerator::class, config('csp.nonce_generator'));

        $this->app->singleton('csp-nonce', function () {
            return app(NonceGenerator::class)->generate();
        });
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/csp.php', 'csp');
    }
}

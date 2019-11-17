<?php

namespace TPenaranda\Aiditokens\Providers;

use Illuminate\Support\ServiceProvider;
use TPenaranda\Aiditokens\ModelToken;

class AiditokensServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (method_exists($this, 'loadMigrationsFrom')) {
            $this->loadMigrationsFrom(__DIR__ . '/../Migrations');
        }
    }

    public function register()
    {
        $this->app['tpenaranda-aiditokens'] = $this->app->singleton(ModelToken::class, function ($app) {
            return new ModelToken;
        });
    }
}

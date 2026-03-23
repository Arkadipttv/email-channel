<?php

namespace Arkadip\EmailChannel;

use Illuminate\Support\ServiceProvider;

class EmailChannelServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/email-channel.php',
            'email-channel'
        );
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/email-channel.php' => config_path('email-channel.php'),
        ], 'email-channel-config');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadRoutesFrom(__DIR__.'/Http/routes.php');
    }
}
<?php

namespace Arkadip\EmailChannel;

use Illuminate\Support\ServiceProvider;

class EmailChannelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        // ✅ Merge config
        $this->mergeConfigFrom(
            __DIR__ . '/../config/email-channel.php',
            'email-channel'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        // ✅ Publish config
        $this->publishes([
            __DIR__ . '/../config/email-channel.php' => config_path('email-channel.php'),
        ], 'email-channel-config');

        // ✅ Publish views (optional override in app)
        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('views/vendor/email-channel'),
        ], 'email-channel-views');

        // ✅ Load views (for package usage)
        $this->loadViewsFrom(
            __DIR__ . '/resources/views',
            'email-channel'
        );

        // ✅ Load migrations
        $this->loadMigrationsFrom(
            __DIR__ . '/../database/migrations'
        );

        // ✅ Load routes
        $this->loadRoutesFrom(
            __DIR__ . '/Http/routes.php'
        );
    }
}
<?php

namespace Lamoda\Ximilar\Api\Client;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/ximilar-api-client.php', 'ximilar-api-client');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/ximilar-api-client.php' => config_path('ximilar-api-client.php'),
        ]);
    }
}

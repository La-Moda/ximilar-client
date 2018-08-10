<?php

namespace Lamoda\Ximilar;

use GuzzleHttp\Client;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/ximilar-api-client.php', 'ximilar-api-client');

        $this->app->singleton('XimilarApi', function ($app) {
            $client = new Client([ 'base_uri' => config('ximilar-api-client.base_uri')]);
            
            // if (config('app.env') == 'testing') {
            //     return new XimilarApi(
            //         new SnapshotClient(['base_uri' => config('ximilar-api-client.base_uri')])
            //     );
            // }

            return new XimilarApi($client);
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/ximilar-api-client.php' => config_path('ximilar-api-client.php'),
        ]);
    }
}

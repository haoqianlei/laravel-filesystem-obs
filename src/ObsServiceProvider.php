<?php

namespace Back\Obs;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;

class ObsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     */
    public function register()
    {
        Storage::extend('obs', function ($app, $config) {

            $client = new ObsClient($config);

            $bucket = $config['bucket'] ?? null;
            $endpoint = $config['endpoint'] ?? null;

            return new Filesystem(new ObsAdapter($client, $bucket, $endpoint));
        });
    }
}

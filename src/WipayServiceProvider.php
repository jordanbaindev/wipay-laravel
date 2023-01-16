<?php

namespace Jordanbaindev\Wipay;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class WipayServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/wipay.php' => config_path('wipay.php'),
        ]);

        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

        $this->loadViewsFrom(__DIR__.'/resources/views', 'wipay');
    }

    public function register()
    {
        $this->app->bind('wipay-voucher', function ($app) {
            $base_uri = ($app['config']->get('app.env') === 'local')
                ? "https://sandbox.wipayfinancial.com/v1/"
                : "https://wipayfinancial.com/v1/"
            ;
            $client = new Client([
                'base_uri' => $base_uri,
                'headers' => ['content-type' => 'application/x-www-form-urlencoded']
            ]);
            return new WipayVoucher($client);
        });
    }
}

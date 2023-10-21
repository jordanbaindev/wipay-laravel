<?php

namespace Jordanbaindev\Wipay;

use Illuminate\Support\ServiceProvider;

class WipayServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/wipay.php' => config_path('wipay.php'),
        ], 'wipay-config');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'wipay');
    }

    public function register()
    {
        $this->app->bind('wipay-voucher', function ($app) {
            $config = $app['config']['wipay'];
            $is_sandbox = $config['environment'] === 'sandbox';

            $account_number = $is_sandbox ? 4630 : $config['account_number'];

            return new WipayVoucher(
                account_number: $account_number,
                is_sandbox: $is_sandbox
            );
        });

        $this->app->bind('wipay-card', function ($app) {
            $config = $app['config']['wipay'];
            $is_sandbox = $config['environment'] === 'sandbox';

            $account_number = $is_sandbox ? 1234567890 : $config['account_number'];
            $api_key = $is_sandbox ? 123 : $config['api_key'];

            return new WipayCard(
                account_number: $account_number,
                api_key: $api_key,
                environment: $config['environment'],
                fee_structure: $config['fee_structure'],
                origin: $config['origin'],
                version: $config['version']
            );
        });
    }
}

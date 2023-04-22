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
            $app_env = $app['config']['wipay.environment'];

            $account_number = ( $app_env === 'sandbox' )
                ? 4630
                : $app['config']->get('wipay.account_number')
            ;
            $base_uri = ( $app_env === 'local')
                ? 'https://sandbox.wipayfinancial.com/v1/voucher_pay'
                : 'https://wipayfinancial.com/v1/voucher_pay'
            ;

            $headers = ['Content-Type: application/x-www-form-urlencoded'];

            return new WipayVoucher($account_number, $base_uri, $headers);
        });

        $this->app->bind('wipay-card', function ($app) {
            $app_env = $app['config']['wipay.environment'];

            $account_number = ( $app_env === 'sandbox' )
                ? 1234567890
                : $app['config']->get('wipay.account_number');

            $api_key = ( $app_env === 'sandbox' )
                ? 123
                : $app['config']->get('wipay.api_key');

            $base_uri = 'https://tt.wipayfinancial.com/plugins/payments/request';
            $headers = [
                'Accept: application/json',
                'Content-Type: application/x-www-form-urlencoded'
            ];

            return new WipayCard(
                account_number: $account_number,
                api_key: $api_key,
                base_uri: $base_uri,
                headers: $headers
            );
        });
    }
}

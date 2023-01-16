<?php

namespace Jordanbaindev\Wipay;

use Jordanbain\FirstAtlanticCommerce\Support\VoucherValidation;
use Jordanbaindev\Wipay\App\Http\Controllers\API\AbstractAPI;

class WipayVoucher extends AbstractAPI
{
    public static function check(string $voucher)
    {
        self::post(
            'voucher_check',
            ['voucher' => $voucher],
            VoucherValidation::check(),
        );
    }

    public static function pay(float $total, string $details = '', string $voucher)
    {
        self::post(
            'voucher_pay',
            [
                'account_number' => config('wipay.account_number'),
                'details' => $details,
                'total' => $total,
                'voucher' => $voucher
            ],
            VoucherValidation::pay()
        );
    }
}

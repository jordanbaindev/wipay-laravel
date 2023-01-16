<?php

namespace Jordanbain\FirstAtlanticCommerce\Support;

// use Illuminate\Support\Arr;
// use Illuminate\Validation\Rule;

class VoucherValidation
{
    private const CHECK = [
        'voucher' => 'required|string|size:12'
    ];

    private const PAY = [
        'account_number' => 'required|int',
        'details' => 'string|max:255',
        'total' => 'required|numeric|gt:0',
        'voucher' => 'required|string|size:12'
    ];

    public static function check()
    {
        return SELF::CHECK;
    }

    public static function pay()
    {
        return SELF::PAY;
    }
}
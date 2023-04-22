<?php

namespace Jordanbaindev\Wipay\Controllers\Support;

use Illuminate\Validation\Rule;

class ValidationRules
{
    public static function card()
    {
        return [
            'account_number' => 'required|numeric',
            'avs' => 'required|boolean',
            'country_code' => [
                'required',
                Rule::in(['TT'])
            ],
            'currency' => [
                'required',
                Rule::in(['TTD', 'JMD', 'USD'])
            ],
            'data' => 'required',
            'environment' => [
                'required',
                Rule::in(['live', 'sandbox'])
            ],
            'fee_structure' => [
                'required',
                Rule::in(['customer_pay', 'merchant_absorb', 'split'])
            ],
            'method' => [
                'required',
                Rule::in(['credit_card', 'voucher'])
            ],
            'order_id' => 'required|max:48',
            'origin' => 'required|max:32',
            'response_url' => 'required|url|max:255',
            'total' => 'required|numeric',
            'version' => 'required|max:16',

            'fname' => 'string|max:30',
            'lname' => 'string|max:30',
            'email' => 'string|max:50'
        ];
    }

    public static function check_voucher()
    {
        return ['voucher' => 'required|string|size:12'];
    }

    public static function pay_voucher()
    {
        return [
            'account_number' => 'required|numeric',
            'details' => 'string|max:255',
            'total' => 'required|numeric',
            'voucher' => 'required|string|size:12'
        ];
    }
}

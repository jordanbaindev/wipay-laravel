<?php

namespace Jordanbaindev\Wipay;

use Illuminate\Support\Facades\Validator;
use Jordanbaindev\Wipay\Controllers\Support\ValidationRules;
use Jordanbaindev\Wipay\Exceptions\InvalidParameterException;

class WipayVoucher
{
    private string $base_uri;
    private array $headers = [
        'Content-Type: application/x-www-form-urlencoded'
    ];

    public function __construct(
        private int $account_number,
        private bool $is_sandbox
    ) {
        $this->base_uri = $is_sandbox
            ? 'https://sandbox.wipayfinancial.com/v1/voucher_pay'
            : 'https://wipayfinancial.com/v1/voucher_pay';
    }

    public function process(float $total, string $voucher, string $details = '')
    {
        $validated = $this->validation([
            'account_number' => $this->account_number,
            'details' => $details,
            'total' => $total,
            'voucher' => $voucher
        ],ValidationRules::pay_voucher());

        if ($validated === false) return [
            'status' => 'error',
            'msg' => 'Voucher must be 12 characters long.'
        ];

        $curl = curl_init($this->base_uri);
        curl_setopt_array($curl, [
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => $this->headers,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($validated),
            CURLOPT_RETURNTRANSFER => true
        ]);

        $result = json_decode(curl_exec($curl));
        curl_close($curl);

        return $result;
    }

    // public static function check(string $voucher)
    // {
    //     self::post(
    //         'voucher_check',
    //         ['voucher' => $voucher],
    //         ValidationRules::check_voucher(),
    //     );
    // }

    /**
     * Validate parameters
     *
     * @param string $path
     * @param array $params
     * @param array $rules
     * @return array
     * @throws InvalidParameterException
     */
    private function validation(array $params, array $rules)
    {
        $validator = Validator::make($params, $rules);

        if ($validator->fails()) return false;

        return $validator->validated();
    }
}

<?php

namespace Jordanbaindev\Wipay;

use Illuminate\Support\Facades\Validator;
use Jordanbaindev\Wipay\Controllers\Support\ValidationRules;
use Jordanbaindev\Wipay\Exceptions\InvalidParameterException;

class WipayVoucher
{
    private $base_uri, $headers, $account_number;

    public function __construct(int $account_number, string $base_uri, array $headers) {
        $this->account_number = $account_number;
        $this->base_uri = $base_uri;
        $this->headers = $headers;
    }

    public function pay(float $total, string $voucher, string $details = '')
    {
        $validated = $this->validation([
            'account_number' => $this->account_number,
            // 'details' => $details,
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

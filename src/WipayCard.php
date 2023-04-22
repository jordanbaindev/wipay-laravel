<?php

namespace Jordanbaindev\Wipay;

use Illuminate\Support\Facades\Validator;
use Jordanbaindev\Wipay\Controllers\Support\ValidationRules;
use Jordanbaindev\Wipay\Exceptions\InvalidParameterException;

class WipayCard
{
    private
        $environment,
        $fee_structure,
        $origin,
        $version
    ;

    public function __construct(
        private string $account_number,
        private string $api_key,
        private string $base_uri,
        private array $headers
    ) {
        $this->environment = 'sandbox'; //config('wipay.environment');
        $this->fee_structure = config('wipay.fee_structure');
        $this->origin = config('wipay.origin');
        $this->version = config('wipay.version');
    }

    public function process(
        string|int $order_id,
        string $response_url,
        string|int $total,
        string $fname = null,
        string $lname = null,
        string $email = null,
        int $avs = 0,
        string $currency = 'TTD',
        string $country_code = 'TT',
        array $data = [],
        string $method = 'credit_card'
    )
    {
        $validated = $this->validation([
            'account_number' => $this->account_number,
            'fee_structure' => $this->fee_structure,
            'origin' => $this->origin,
            'environment' => $this->environment,

            'avs' => $avs,
            'country_code' => $country_code,
            'currency' => $currency,
            'data' => json_encode($data),
            'method' => $method,
            'order_id' => $order_id,
            'response_url' => $response_url,
            'total' => number_format($total, 2, '.', ''),
            'version' => $this->version,
            'fname' => $fname,
            'lname' => $lname,
            'email' => $email
        ], ValidationRules::card());

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

    /**
     * Validate hash
     *
     * @param string $transaction_id
     * @param string|integer $total
     * @param string $hash
     * @return boolean
     */
    public function validateHash(
        string $transaction_id,
        string|int $total,
        string $hash
    ): bool
    {
        $hash_string = $transaction_id . number_format($total, 2, '.', '') . $this->api_key;
        $calculated_hash = md5($hash_string);

        if ($calculated_hash === $hash) return true;

        return false;
    }

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

        if ($validator->fails()) throw new InvalidParameterException(implode("; ", $validator->errors()->all()), 1);

        return $validator->validated();
    }
}

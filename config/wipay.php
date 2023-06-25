<?php

return [
    'account_number' => 0000000000,
    'api_key' => '123',
    'avs' => false,
    'environment' => env('WIPAY_ENV', 'sandbox'), //* live | sandbox
    'fee_structure' => 'split', //* customer_pay | merchant_absorb | split
    'origin' => 'my_app',
    'version' => '1.0.0'
];

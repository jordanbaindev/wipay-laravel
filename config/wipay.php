<?php

return [
    'account_number' => 0000000000,
    'avs' => false,
    'environment' => env('WIPAY_ENV'), //* live | sandbox
    'fee_structure' => 'split', //* customer_pay | merchant_absorb | split
    'origin' => 'lets_shop_customer_app',
    'version' => '1.0.0'
];
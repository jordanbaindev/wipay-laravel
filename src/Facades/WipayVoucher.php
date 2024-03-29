<?php

namespace Jordanbaindev\Wipay\Facades;

use Illuminate\Support\Facades\Facade;

class WipayVoucher extends Facade
{

    /**
    * Get the registered name of the component.
    *
    * @return string
    */
    protected static function getFacadeAccessor() { return 'wipay-voucher'; }
}
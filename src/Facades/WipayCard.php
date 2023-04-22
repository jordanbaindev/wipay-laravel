<?php

namespace Jordanbaindev\Wipay\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method mixed static process()
 * @method mixed static validateHash()
 */

class WipayCard extends Facade
{

    /**
    * Get the registered name of the component.
    *
    * @return string
    */
    protected static function getFacadeAccessor() { return 'wipay-card'; }
}

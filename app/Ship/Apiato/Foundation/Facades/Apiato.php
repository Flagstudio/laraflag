<?php

namespace App\Ship\Apiato\Foundation\Facades;

use Illuminate\Support\Facades\Facade;

class Apiato extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Apiato';
    }
}

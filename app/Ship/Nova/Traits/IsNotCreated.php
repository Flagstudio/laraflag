<?php

namespace App\Ship\Nova\Traits;

use Illuminate\Http\Request;

trait IsNotCreated
{
    public static function authorizedToCreate(Request $request)
    {
        return false;
    }
}
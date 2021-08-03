<?php

namespace App\Containers\Nova\Traits;

use Illuminate\Http\Request;

trait IsNotUpdated
{
    public function authorizedToUpdate(Request $request)
    {
        return false;
    }
}

<?php

namespace App\Ship\Nova\Traits;

use Illuminate\Http\Request;

trait IsNotDeleted
{
    public function authorizedToDelete(Request $request)
    {
        return false;
    }
}

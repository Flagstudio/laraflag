<?php

namespace App\Containers\Authentication\Http\Responders;

use App\Ship\Parents\Responders\ErrorResponder;
use Illuminate\View\View;

class ErrorVerificationResponder extends ErrorResponder
{
    public function view(): ?View
    {
        return null;
    }
}

<?php

namespace App\Ship\Responders;

use \App\Ship\Parents\Responders\ErrorResponder as ParentResponder;
use Illuminate\View\View;

class ErrorResponder extends ParentResponder
{
    public function view(): ?View
    {
        return null;
    }
}

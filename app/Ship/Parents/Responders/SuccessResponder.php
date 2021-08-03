<?php

namespace App\Ship\Parents\Responders;

use App\Ship\Apiato\Abstracts\Responders\AbstractResponder;

abstract class SuccessResponder extends AbstractResponder
{
    abstract public function json(array $data);
}

<?php

namespace App\Ship\Traits;

trait CanCallResponder
{
    public function responder(...$parameters)
    {
        return resolve(\App\Ship\Apiato\Helpers\CallResponder::class)
            ->responder(...$parameters);
    }
}

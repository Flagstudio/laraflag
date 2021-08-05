<?php

namespace App\Ship\Traits;

trait CanCallSubAction
{
    public function action(...$parameters)
    {
        return resolve(\App\Ship\Apiato\Helpers\CallAction::class)
            ->action(...$parameters);
    }
}

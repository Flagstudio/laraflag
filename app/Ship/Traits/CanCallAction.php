<?php

namespace App\Ship\Traits;

trait CanCallAction
{
    public function action(...$parameters)
    {
        return resolve(\App\Ship\Apiato\Helpers\CallAction::class)
            ->action(...$parameters);
    }
}

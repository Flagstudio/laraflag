<?php

namespace App\Ship\Traits;

trait CanCallTask
{
    public function task(...$parameters)
    {
        return resolve(\App\Ship\Apiato\Helpers\CallTask::class)
            ->task(...$parameters);
    }
}

<?php

namespace App\Ship\Apiato\Helpers;

use App\Ship\Parents\Tasks\Task;

class CallTask
{
    use GetCallableInstance;

    public function task(...$parameters)
    {
        list($instance, $args) = $this->getInstance(...$parameters);

        if (!($instance instanceof Task)) {
            throw new \Exception("Class $parameters[0] not implement Task");
        }

        return $instance->run(...$args);
    }
}

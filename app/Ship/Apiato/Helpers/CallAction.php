<?php

namespace App\Ship\Apiato\Helpers;

use App\Ship\Parents\Actions\Action;

class CallAction
{
    use GetCallableInstance;

    public function action(...$parameters)
    {
        list($instance, $args) = $this->getInstance(...$parameters);

        if (!($instance instanceof Action)) {
            throw new \Exception("Class $parameters[0] not implement Action");
        }

        return $instance->run(...$args);
    }
}

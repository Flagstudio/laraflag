<?php

namespace App\Ship\Apiato\Helpers;

use App\Ship\Apiato\Abstracts\Responders\AbstractResponder;

class CallResponder
{
    use GetCallableInstance;

    public function responder(...$parameters)
    {
        list($instance, $args) = $this->getInstance(...$parameters);

        if (!($instance instanceof AbstractResponder)) {
            throw new \Exception("Class $parameters[0] not implement Action");
        }

        return $instance->handle(...$args);
    }
}

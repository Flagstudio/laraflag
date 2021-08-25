<?php

namespace App\Ship\Apiato\Helpers;

trait GetCallableInstance
{
    use HasParameters;

    protected function getInstance(...$parameters)
    {
        $this->validateParameters($parameters);

        $class = $parameters[0];
        $args = array_slice($parameters, 1);

        return [resolve($class), $args];
    }
}

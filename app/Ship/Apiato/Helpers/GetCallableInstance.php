<?php

namespace App\Ship\Apiato\Helpers;

trait GetCallableInstance
{
    use HasParameters;

    protected function getInstance(...$parameters)
    {
        $this->validateParameters($parameters);

        $args = [];
        if (isset($parameters[1])) {
            $args = $this->extractArguments($parameters[1]);
        }

        return [resolve($parameters[0]), $args];
    }
}

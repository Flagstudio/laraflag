<?php

namespace App\Ship\Apiato\Helpers;

use App\Ship\Apiato\Exceptions\ClassDoesNotExistException;
use App\Ship\Apiato\Exceptions\InvalidArgumentException;

trait HasParameters
{
    protected function validateParameters($parameters)
    {
        if (empty($parameters) || !is_string($parameters[0])) {
            throw new InvalidArgumentException();
        }

        if (!class_exists($parameters[0])) {
            throw new ClassDoesNotExistException();
        }
    }

    protected function extractArguments($parameters)
    {
        if (!is_array($parameters)) {
            return [$parameters];
        }

        return $parameters;
    }
}

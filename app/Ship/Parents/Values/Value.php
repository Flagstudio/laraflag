<?php

namespace App\Ship\Parents\Values;

use App\Ship\Apiato\Abstracts\Values\Value as AbstractValue;

abstract class Value extends AbstractValue
{
    public function get($model, string $key, $value, array $attributes)
    {
        return $value;
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return $value;
    }
}

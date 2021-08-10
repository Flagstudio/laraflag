<?php

namespace App\Ship\Apiato\Abstracts\Values;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

abstract class Value implements CastsAttributes
{
    abstract public function get($model, string $key, $value, array $attributes);

    abstract public function set($model, string $key, $value, array $attributes);
}

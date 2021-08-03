<?php

namespace App\Ship\Apiato\Abstracts\Enum;

use Spatie\Enum\Enum as BaseEnum;

abstract class Enum extends BaseEnum
{
    protected static string $idsEnum = '';

    public static function __callStatic(string $name, array $arguments)
    {
        try {
            if (!class_exists(static::$idsEnum)) {
                throw new \Exception();
            }
            $id = static::$idsEnum::$name()->label;
            return static::labels()[$id];
        } catch (\Exception $e) {
            return parent::__callStatic($name, $arguments);
        }
    }
}

<?php

namespace App\Ship\Apiato\Abstracts\Transporters;

use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Str;
use Spatie\DataTransferObject\DataTransferObject;

#[Strict]
abstract class Transporter extends DataTransferObject
{
    public static function fromRequest(Request $request): self
    {
        return new static(
            self::parseRequestFields(
                $request->validated()
            )
        );
    }

    public static function parseRequestFields(array $fields)
    {
        $castKeys = static::castKeys();
        $keys = array_keys($fields);
        $keys = array_map(
            fn ($key) => $castKeys[$key] ?? Str::camel($key),
            $keys
        );
        return array_combine($keys, $fields);
    }

    abstract public static function castKeys(): array;
}

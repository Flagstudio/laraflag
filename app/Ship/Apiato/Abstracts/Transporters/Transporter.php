<?php

namespace App\Ship\Apiato\Abstracts\Transporters;

use App\Ship\Parents\Entities\Entity;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Str;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\FieldValidator;
use Spatie\DataTransferObject\ValueCaster;

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

    protected function castValue(ValueCaster $valueCaster, FieldValidator $fieldValidator, $value)
    {
        $type = $fieldValidator->allowedTypes[0];

        if (class_exists($type) && ($object = new $type) instanceof Entity) {
            return $object->find($value);
        }

        if (is_array($value)) {
            return $valueCaster->cast($value, $fieldValidator);
        }

        return $value;
    }
}

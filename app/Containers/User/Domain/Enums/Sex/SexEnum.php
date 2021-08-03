<?php

namespace App\Containers\User\Domain\Enums\Sex;

use App\Ship\Parents\Enum\Enum;

/**
 * @method static self man()
 * @method static self woman()
 */
class SexEnum extends Enum
{
    public static function labels(): array
    {
        return [
            'man' => 0,
            'woman' => 1,
            'other' => 2,
        ];
    }
}

<?php

namespace App\Containers\User\Domain\Enums\Sex;

use App\Ship\Parents\Enum\Enum;

class SexTitleEnum extends Enum
{
    public static string $idsEnum = SexEnum::class;

    public static function labels(): array
    {
        return [
            0 => 'Мужской',
            1 => 'Женский',
        ];
    }
}

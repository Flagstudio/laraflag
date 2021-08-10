<?php

namespace App\Containers\User\Transfers\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class UserUpdateTransporter extends Transporter
{
    public string $name;

    public static function castKeys(): array
    {
        return [];
    }
}

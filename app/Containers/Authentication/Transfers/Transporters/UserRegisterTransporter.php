<?php

namespace App\Containers\Authentication\Transfers\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class UserRegisterTransporter extends Transporter
{
    public string $phone;

    public static function castKeys(): array
    {
        return [];
    }
}

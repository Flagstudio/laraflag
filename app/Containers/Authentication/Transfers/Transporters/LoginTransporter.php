<?php

namespace App\Containers\Authentication\Transfers\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class LoginTransporter extends Transporter
{
    public string $phone;

    public string $verifyCode;

    public static function castKeys(): array
    {
        return [];
    }
}

<?php

namespace App\Containers\User\Transfers\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class UserUpdateTransporter extends Transporter
{
    public string $name;
    public string $phone;
    public string $email;
    public string $birth;
    public bool $allow_ads;

    public static function castKeys(): array
    {
        return [
            'birthday' => 'birth',
            'offers' => 'allow_ads',
        ];
    }
}

<?php

namespace App\Containers\User\Domain\Entities;

use App\Ship\Parents\Entities\UserEntity;

class User extends UserEntity
{
    protected $dates = [
        'birthday',
        'phone_verified_at',
    ];
}

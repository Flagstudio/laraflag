<?php

namespace App\Containers\User\Domain\Entities;

use App\Ship\Parents\Entities\UserEntity;

class User extends UserEntity
{
    protected $guarded = [];

    protected $dates = [
        'birth',
        'phone_verified_at',
    ];
}

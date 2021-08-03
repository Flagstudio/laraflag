<?php

namespace App\Ship\Parents\Entities;

use App\Ship\Apiato\Abstracts\Entities\UserEntity as AbstractUserEntity;
use Illuminate\Notifications\Notifiable;

abstract class UserEntity extends AbstractUserEntity
{
    use Notifiable;

    protected $hidden = [
        'password',
        'remember_token',
    ];
}

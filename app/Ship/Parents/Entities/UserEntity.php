<?php

namespace App\Ship\Parents\Entities;

use App\Ship\Apiato\Abstracts\Entities\UserEntity as AbstractUserEntity;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

abstract class UserEntity extends AbstractUserEntity implements JWTSubject
{
    use Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}

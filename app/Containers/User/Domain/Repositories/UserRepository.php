<?php

namespace App\Containers\User\Domain\Repositories;

use App\Containers\User\Domain\Entities\User;
use App\Ship\Parents\Repositories\Repository;

class UserRepository extends Repository
{
    public function getByPhone(string $phone)
    {
        return User::wherePhone($phone)->first();
    }
}

<?php

namespace App\Containers\User\Tasks;

use App\Containers\Authentication\Transfers\Transporters\UserRegisterTransporter;
use App\Containers\User\Domain\Entities\User;
use App\Containers\User\Exceptions\CreateUserException;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Str;

class StoreUserTask extends Task
{
    public function run(UserRegisterTransporter $fields)
    {
        try {
            return User::create([
                'uuid' => Str::uuid(),
                'name' => '',
                'phone' => $fields->phone
            ]);
        } catch (\Exception $e) {
            throw new CreateUserException($e->getMessage());
        }
    }
}

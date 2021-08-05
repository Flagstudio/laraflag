<?php

namespace App\Containers\User\Tasks;

use App\Containers\User\Exceptions\UserUpdatingException;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Facades\Auth;

class UserUpdateTask extends Task
{
    public function run(array $fields)
    {
        try {
            return Auth::user()->update($fields);
        } catch (\Exception $e) {
            throw new UserUpdatingException;
        }
    }
}

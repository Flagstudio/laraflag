<?php

namespace App\Containers\User\Tasks;

use App\Containers\User\Domain\Entities\User;
use App\Containers\User\Exceptions\ErrorVerificationException;
use App\Ship\Parents\Tasks\Task;

class CheckVerifyCodeTask extends Task
{
    public function run(string $phone, string $code): ?User
    {
        try {
            return User::wherePhone($phone)
                ->where('verify_code', $code)
                ->first();
        } catch (\Exception $e) {
            throw new ErrorVerificationException;
        }
    }
}

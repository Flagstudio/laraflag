<?php

namespace App\Containers\User\Tasks;

use App\Containers\User\Domain\Entities\User;
use App\Containers\User\Exceptions\ErrorVerificationException;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Facades\App;

class CheckVerifyCodeTask extends Task
{
    public function run(string $phone, string $code): ?User
    {
        try {
            if ((App::isLocal() || app()->environment('dev')) && $code === '0000') {
                return User::wherePhone($phone)->first();
            }

            return User::wherePhone($phone)
                ->where('verify_code', $code)
                ->first();
        } catch (\Exception $e) {
            throw new ErrorVerificationException;
        }
    }
}

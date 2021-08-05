<?php

namespace App\Containers\User\Tasks;

use App\Containers\User\Exceptions\ErrorVerificationException;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Facades\Auth;

class CheckVerifyCodeTask extends Task
{
    public function run(string $code)
    {
        try {
            return Auth::user()->verify_code === $code;
        } catch (\Exception $e) {
            throw new ErrorVerificationException;
        }
    }
}

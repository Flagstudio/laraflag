<?php

namespace App\Containers\Authentication\Actions;

use App\Containers\Authentication\Http\Responders\SuccessVerificationResponder;
use App\Containers\Authentication\Http\Responders\UnauthorizedResponder;
use App\Containers\Authentication\Tasks\GenerateJWTTokenForUserTask;
use App\Containers\Authentication\Transfers\Transporters\LoginTransporter;
use App\Containers\User\Exceptions\WrongVerificationCodeException;
use App\Containers\User\Tasks\CheckVerifyCodeTask;
use App\Ship\Parents\Actions\Action;

class LoginAction extends Action
{
    public function run(LoginTransporter $data)
    {
        try {
            $user = $this->task(
                CheckVerifyCodeTask::class,
                $data->phone,
                $data->verifyCode,
            );

            if (!$user) {
                throw new WrongVerificationCodeException();
            }

            return $this->responder(
                SuccessVerificationResponder::class,
                $this->task(GenerateJWTTokenForUserTask::class, $user)
            );
        } catch (\Exception $e) {
            return $this->responder(UnauthorizedResponder::class, $e->getMessage());
        }
    }
}

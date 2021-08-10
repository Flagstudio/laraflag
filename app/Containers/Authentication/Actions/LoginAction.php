<?php

namespace App\Containers\Authentication\Actions;

use App\Containers\Authentication\Transfers\Responders\SuccessVerificationResponder;
use App\Containers\Authentication\Transfers\Responders\UnauthorizedResponder;
use App\Containers\Authentication\Transfers\Transporters\LoginTransporter;
use App\Containers\User\Exceptions\WrongVerificationCodeException;
use App\Containers\User\Tasks\CheckVerifyCodeTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Facades\Auth;

class LoginAction extends Action
{
    public function run(LoginTransporter $data)
    {
        try {
            $user = $this->task(
                CheckVerifyCodeTask::class,
                [
                    $data->phone,
                    $data->verifyCode,
                ]
            );

            if (!$user) {
                throw new WrongVerificationCodeException();
            }

            $token = Auth::login($user);

            if (!$token) {
                return $this->responder(UnauthorizedResponder::class);
            }

            return $this->responder(
                SuccessVerificationResponder::class,
                [
                    [
                        'accessToken' => $token,
                        'expires_in' => Auth::factory()->getTTL() * 60,
                    ]
                ]
            );
        } catch (\Exception $e) {
            return $this->responder(UnauthorizedResponder::class, $e->getMessage());
        }
    }
}

<?php

namespace App\Containers\Authentication\Actions;

use App\Containers\Authentication\Transfers\Responders\UserExistsResponder;
use App\Containers\Authentication\Transfers\Responders\UserRegisterResponder;
use App\Containers\User\Tasks\FindUserByPhoneTask;
use App\Containers\User\Tasks\GenerateActivationCodeTask;
use App\Containers\User\Tasks\StoreUserTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Responders\ErrorResponder;
use Illuminate\Support\Facades\Auth;

class RegisterAction extends Action
{
    public function run(string $phone)
    {
        try {
            $user = $this->task(FindUserByPhoneTask::class, $phone);

            if ($user) {
                Auth::login($user);
                return $this->responder(UserExistsResponder::class);
            }

            $user = $this->task(StoreUserTask::class, (object) ['phone' => $phone]);

            Auth::login($user);

            $this->task(GenerateActivationCodeTask::class);

            if (!config('authentication.register_test_mode')) {
                //TODO send mail with activation code
            }

            return $this->responder(UserRegisterResponder::class);
        } catch (\Exception $e) {
            return $this->responder(ErrorResponder::class, $e->getMessage());
        }
    }
}

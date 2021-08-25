<?php

namespace App\Containers\Authentication\Actions;

use App\Containers\Authentication\Http\Responders\UserExistsResponder;
use App\Containers\Authentication\Http\Responders\UserRegisterResponder;
use App\Containers\Authentication\Transfers\Transporters\UserRegisterTransporter;
use App\Containers\User\Tasks\FindUserByPhoneTask;
use App\Containers\User\Tasks\GenerateActivationCodeTask;
use App\Containers\User\Tasks\StoreUserTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Responders\ErrorResponder;

class RegisterAction extends Action
{
    public function run(UserRegisterTransporter $transfer)
    {
        try {
            $userIsNew = false;
            if (!$user = $this->task(FindUserByPhoneTask::class, $transfer->phone)) {
                $userIsNew = true;

                $user = $this->task(StoreUserTask::class, $transfer->phone);
            }

            $this->task(GenerateActivationCodeTask::class, $user);

            if (!config('authentication.register_test_mode')) {
                //TODO send sms with activation code
            }

            if ($userIsNew) {
                return $this->responder(UserRegisterResponder::class);
            }

            return $this->responder(UserExistsResponder::class);
        } catch (\Exception $e) {
            return $this->responder(ErrorResponder::class, $e->getMessage());
        }
    }
}

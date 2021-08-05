<?php

namespace App\Containers\Authentication\Actions;

use App\Containers\Authentication\Transfers\Responders\SuccessVerificationResponder;
use App\Containers\User\Exceptions\WrongVerificationCodeException;
use App\Containers\User\Tasks\CheckVerifyCodeTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Responders\ErrorResponder;

class VerifyAction extends Action
{
    public function run(string $code)
    {
        try {
            if (!$this->task(CheckVerifyCodeTask::class, $code)) {
                throw new WrongVerificationCodeException();
            }

            return $this->responder(SuccessVerificationResponder::class);
        } catch (\Exception $e) {
            return $this->responder(ErrorResponder::class, $e->getMessage());
        }
    }
}

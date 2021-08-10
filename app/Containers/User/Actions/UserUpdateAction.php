<?php

namespace App\Containers\User\Actions;

use App\Containers\User\Tasks\UserUpdateTask;
use App\Containers\User\Transfers\Responders\UserUpdatedResponder;
use App\Containers\User\Transfers\Transporters\UserUpdateTransporter;
use App\Ship\Parents\Actions\Action;
use App\Ship\Responders\ErrorResponder;

class UserUpdateAction extends Action
{
    public function run(UserUpdateTransporter $fields)
    {
        try {
            $this->task(UserUpdateTask::class, [$fields->toArray()]);

            return $this->responder(UserUpdatedResponder::class);
        } catch (\Exception $e) {
            return $this->responder(ErrorResponder::class, $e->getMessage());
        }
    }
}

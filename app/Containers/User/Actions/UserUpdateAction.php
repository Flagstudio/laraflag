<?php

namespace App\Containers\User\Actions;

use App\Containers\User\Tasks\SendUserToOneSTask;
use App\Containers\User\Tasks\UserUpdateTask;
use App\Containers\User\Http\Responders\UserUpdatedResponder;
use App\Containers\User\Transfers\Transporters\UserUpdateTransporter;
use App\Ship\Parents\Actions\Action;
use App\Ship\Responders\ErrorResponder;
use Illuminate\Support\Facades\Auth;

class UserUpdateAction extends Action
{
    public function run(UserUpdateTransporter $fields)
    {
        try {
            $data = array_filter($fields->toArray(), fn ($item) => $item !== null);

            $this->task(UserUpdateTask::class, $data);

            $this->task(
                SendUserToOneSTask::class,
                [
                    'phone' => Auth::user()->phone,
                    'name' => $fields->name,
                    'email' => $fields->email,
                ],
            );

            return $this->responder(UserUpdatedResponder::class);
        } catch (\Exception $e) {
            return $this->responder(
                ErrorResponder::class,
                $e->getMessage()
            );
        }
    }
}

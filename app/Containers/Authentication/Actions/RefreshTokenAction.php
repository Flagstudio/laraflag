<?php

namespace App\Containers\Authentication\Actions;

use App\Containers\Authentication\Http\Responders\TokenRefreshedResponder;
use App\Containers\Authentication\Tasks\RefreshJWTTokenForUserTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Responders\ErrorResponder;

class RefreshTokenAction extends Action
{
    public function run()
    {
        try {
            return $this->responder(
                TokenRefreshedResponder::class,
                $this->task(RefreshJWTTokenForUserTask::class),
            );
        } catch (\Exception $e) {
            return $this->responder(ErrorResponder::class, $e->getMessage());
        }
    }
}

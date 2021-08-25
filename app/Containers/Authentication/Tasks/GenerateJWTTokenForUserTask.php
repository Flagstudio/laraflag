<?php

namespace App\Containers\Authentication\Tasks;

use App\Containers\User\Domain\Entities\User;
use App\Containers\User\Exceptions\GenerateJWTTonekForUserException;
use App\Ship\Parents\Tasks\Task;
use Tymon\JWTAuth\Facades\JWTAuth;

class GenerateJWTTokenForUserTask extends Task
{
    public function run(User $user)
    {
        try {
            return [
                'accessToken' => JWTAuth::fromUser($user),
                'expires_in' => now()->addDays(config('authentication.jwt_life_time')),
            ];
        } catch (\Exception $e) {
            throw new GenerateJWTTonekForUserException;
        }
    }
}

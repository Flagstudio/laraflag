<?php

namespace App\Containers\Authentication\Tasks;

use App\Containers\User\Exceptions\GenerateJWTTonekForUserException;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Facades\Auth;

class RefreshJWTTokenForUserTask extends Task
{
    public function run()
    {
        try {
            return [
                'accessToken' => Auth::refresh(),
                'expires_in' => now()->addDays(config('authentication.jwt_life_time')),
            ];
        } catch (\Exception $e) {
            throw new GenerateJWTTonekForUserException;
        }
    }
}

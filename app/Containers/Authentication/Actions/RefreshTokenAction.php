<?php

namespace App\Containers\Authentication\Actions;

use App\Containers\Authentication\Transfers\Responders\TokenRefreshedResponder;
use App\Ship\Parents\Actions\Action;
use App\Ship\Responders\ErrorResponder;
use Illuminate\Support\Facades\Auth;

class RefreshTokenAction extends Action
{
    public function run()
    {
        try {
            $data = [
                'accessToken' => Auth::refresh(),
                'expires_in' => Auth::factory()->getTTL() * 60,
            ];

            return $this->responder(TokenRefreshedResponder::class, [$data]);
        } catch (\Exception $e) {
            return $this->responder(ErrorResponder::class, $e->getMessage());
        }
    }
}

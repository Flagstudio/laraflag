<?php

namespace App\Containers\Authentication\Http\Controllers;

use App\Containers\Authentication\Actions\LoginAction;
use App\Containers\Authentication\Actions\LogoutAction;
use App\Containers\Authentication\Actions\RefreshTokenAction;
use App\Containers\Authentication\Http\Requests\LoginRequest;
use App\Ship\Parents\Controllers\Controller;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        return $this->action(
            LoginAction::class,
            $request->transportered(),
        );
    }

    public function logout()
    {
        return $this->action(
            LogoutAction::class
        );
    }

    public function refresh()
    {
        return $this->action(
            RefreshTokenAction::class
        );
    }
}

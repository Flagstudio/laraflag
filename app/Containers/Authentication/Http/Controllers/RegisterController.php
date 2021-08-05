<?php

namespace App\Containers\Authentication\Http\Controllers;

use App\Containers\Authentication\Actions\RegisterAction;
use App\Containers\Authentication\Http\Requests\UserRegisterRequest;
use App\Ship\Parents\Controllers\Controller;

class RegisterController extends Controller
{
    public function store(UserRegisterRequest $request)
    {
        $data = $request->validated();
        return $this->action(RegisterAction::class, $data['phone']);
    }
}

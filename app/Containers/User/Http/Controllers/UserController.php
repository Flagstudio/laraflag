<?php

namespace App\Containers\User\Http\Controllers;

use App\Containers\User\Actions\UserUpdateAction;
use App\Containers\User\Http\Requests\UserUpdateRequest;
use App\Ship\Parents\Controllers\Controller;

class UserController extends Controller
{
    public function update(UserUpdateRequest $request)
    {
        return $this->action(
            UserUpdateAction::class,
            $request->transportered(),
        );
    }
}

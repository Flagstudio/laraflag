<?php

namespace App\Containers\Authentication\Actions;

use App\Containers\Authentication\Http\Responders\LogoutResponder;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Facades\Auth;

class LogoutAction extends Action
{
    public function run()
    {
        Auth::logout();
        return $this->responder(LogoutResponder::class);
    }
}

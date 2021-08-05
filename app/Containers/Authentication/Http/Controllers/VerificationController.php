<?php

namespace App\Containers\Authentication\Http\Controllers;

use App\Containers\Authentication\Actions\VerifyAction;
use App\Containers\Authentication\Http\Requests\VerifyCodeRequest;
use App\Ship\Parents\Controllers\Controller;

class VerificationController extends Controller
{
    public function verify(VerifyCodeRequest $request)
    {
        $data = $request->validated();
        return $this->action(VerifyAction::class, $data['verify_code']);
    }
}

<?php

namespace App\Containers\Authentication\Http\Requests;

use App\Ship\Parents\Requests\Request;

class VerifyCodeRequest extends Request
{
    public function rules(): array
    {
        return [
            'verify_code' => 'required|digits:4'
        ];
    }
}

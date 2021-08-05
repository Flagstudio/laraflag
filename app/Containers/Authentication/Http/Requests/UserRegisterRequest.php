<?php

namespace App\Containers\Authentication\Http\Requests;

use App\Ship\Parents\Requests\Request;

class UserRegisterRequest extends Request
{
    public function rules(): array
    {
        return [
            'phone' => 'required|min:10'
        ];
    }
}

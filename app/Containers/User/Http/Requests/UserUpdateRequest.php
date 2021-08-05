<?php

namespace App\Containers\User\Http\Requests;

use App\Ship\Parents\Requests\Request;

class UserUpdateRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3'
        ];
    }
}

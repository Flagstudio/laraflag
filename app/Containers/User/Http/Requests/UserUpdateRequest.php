<?php

namespace App\Containers\User\Http\Requests;

use App\Containers\User\Transfers\Transporters\UserUpdateTransporter;
use App\Ship\Parents\Requests\Request;

class UserUpdateRequest extends Request
{
    public function transporter(): string
    {
        return UserUpdateTransporter::class;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3',
            'phone' => 'nullable|string|min:10',
            'email' => 'nullable|email',
            'birthday' => 'nullable|date',
            'offers' => 'nullable|boolean',
        ];
    }
}

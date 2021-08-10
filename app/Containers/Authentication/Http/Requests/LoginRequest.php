<?php

namespace App\Containers\Authentication\Http\Requests;

use App\Containers\Authentication\Transfers\Transporters\LoginTransporter;
use App\Ship\Parents\Requests\Request;

class LoginRequest extends Request
{
    public function transporter(): string
    {
        return LoginTransporter::class;
    }

    public function rules(): array
    {
        return [
            'phone' => 'required|exists:users',
            'verify_code' => 'required|digits:4'
        ];
    }
}

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
            'phone' => 'required|numeric|regex:/\+79[0-9]{9}/|exists:users',
            'verify_code' => 'required|digits:4'
        ];
    }
}

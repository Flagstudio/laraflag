<?php

namespace App\Containers\Authentication\Http\Requests;

use App\Containers\Authentication\Transfers\Transporters\UserRegisterTransporter;
use App\Ship\Parents\Requests\Request;

class UserRegisterRequest extends Request
{
    public function transporter(): string
    {
        return UserRegisterTransporter::class;
    }

    public function rules(): array
    {
        return [
            'phone' => 'required|numeric|regex:/\+79[0-9]{9}/'
        ];
    }
}

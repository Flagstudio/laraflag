<?php

namespace App\Ship\Parents\Responders;

use App\Ship\Apiato\Abstracts\Responders\AbstractResponder;

class ErrorResponder extends AbstractResponder
{
    public function json(string $message = ''): array
    {
        return [
            'status' => 400,
            'message' => $message,
        ];
    }
}

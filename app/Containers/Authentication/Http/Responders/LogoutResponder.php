<?php

namespace App\Containers\Authentication\Http\Responders;

use App\Ship\Parents\Responders\SuccessResponder;
use Symfony\Component\HttpFoundation\Response;

class LogoutResponder extends SuccessResponder
{
    public function json(?array $data = []): array
    {
        return [
            'status' => Response::HTTP_OK,
            'data' => [
                'message' => 'User successfully signed out'
            ],
        ];
    }

    public function view()
    {
        // TODO: Implement view() method.
    }
}

<?php

namespace App\Containers\Authentication\Http\Responders;

use App\Ship\Parents\Responders\SuccessResponder;
use Symfony\Component\HttpFoundation\Response;

class UserRegisterResponder extends SuccessResponder
{
    public function json(?array $data = []): array
    {
        return [
            'status' => Response::HTTP_CREATED,
            'data' => [
                'is_new' => true
            ],
        ];
    }

    public function view()
    {
        // TODO: Implement view() method.
    }
}

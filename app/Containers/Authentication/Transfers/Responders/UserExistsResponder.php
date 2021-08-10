<?php

namespace App\Containers\Authentication\Transfers\Responders;

use App\Ship\Parents\Responders\SuccessResponder;
use Symfony\Component\HttpFoundation\Response;

class UserExistsResponder extends SuccessResponder
{
    public function json(?array $data = []): array
    {
        return [
            'status' => Response::HTTP_OK,
            'data' => [
                'is_new' => false
            ],
        ];
    }

    public function view()
    {
        // TODO: Implement view() method.
    }
}

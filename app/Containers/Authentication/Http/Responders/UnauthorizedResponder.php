<?php

namespace App\Containers\Authentication\Http\Responders;

use App\Ship\Parents\Responders\ErrorResponder;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class UnauthorizedResponder extends ErrorResponder
{
    public function json(?string $message = ''): array
    {
        return [
            'status' => Response::HTTP_UNAUTHORIZED,
            'message' => 'Unauthorized',
        ];
    }

    public function view(): ?View
    {
        return null;
    }
}

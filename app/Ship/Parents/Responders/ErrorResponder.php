<?php

namespace App\Ship\Parents\Responders;

use App\Ship\Apiato\Abstracts\Responders\AbstractResponder;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

abstract class ErrorResponder extends AbstractResponder
{
    public function json(?string $message = ''): array
    {
        return [
            'status' => Response::HTTP_BAD_REQUEST,
            'message' => $message,
        ];
    }

    abstract public function view(): ?View;
}

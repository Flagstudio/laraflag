<?php

namespace App\Ship\Parents\Responders;

use App\Ship\Apiato\Abstracts\Responders\AbstractResponder;
use Symfony\Component\HttpFoundation\Response;

abstract class SuccessResponder extends AbstractResponder
{
    public function json(?array $data = []): array
    {
        return [
            'status' => Response::HTTP_OK,
            'data' => $data,
        ];
    }

    abstract public function view();
}

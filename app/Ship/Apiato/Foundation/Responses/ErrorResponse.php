<?php

namespace App\Ship\Apiato\Foundation\Responses;

use Illuminate\Http\Response;

class ErrorResponse
{
    public $status = Response::HTTP_BAD_REQUEST;

    public function json(string $message): array
    {
        return [
            'status' => $this->status,
            'message' => $message,
        ];
    }
}

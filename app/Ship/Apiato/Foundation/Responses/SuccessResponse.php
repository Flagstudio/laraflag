<?php

namespace App\Ship\Apiato\Foundation\Responses;

use Illuminate\Http\Response;

class SuccessResponse
{
    public $status = Response::HTTP_OK;

    public function json($data): array
    {
        return [
            'status' => $this->status,
            'data' => $data,
        ];
    }
}

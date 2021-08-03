<?php

namespace App\Ship\Apiato\Abstracts\Responders;

use Illuminate\Http\JsonResponse;

abstract class AbstractResponder
{
    public function build($data): JsonResponse
    {
        return response()->json($this->json($data));
    }
}

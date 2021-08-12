<?php

namespace App\Ship\Apiato\Abstracts\Responders;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class AbstractResponder
{
    public Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle($data = null): ?JsonResponse
    {
        if ($this->request->wantsJson()) {
            $json = $this->json($data);
            return response()->json($json, $json['status']);
        }
        return $this->view();
    }

    abstract public function json();

    abstract public function view();
}

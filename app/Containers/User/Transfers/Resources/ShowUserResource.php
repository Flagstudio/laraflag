<?php

namespace App\Containers\User\Transfers\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowUserResource extends JsonResource
{
    public function toArray($request = null): array
    {
        return $this->only([
            'name',
            'phone',
            'email',
            'birthday',
            'allow_ads'
        ]);
    }
}
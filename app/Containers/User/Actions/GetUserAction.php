<?php

namespace App\Containers\User\Actions;

use App\Containers\User\Transfers\Resources\ShowUserResource;
use App\Containers\User\Http\Responders\ShowUserResponder;
use App\Ship\Parents\Actions\Action;
use App\Ship\Responders\ErrorResponder;
use Illuminate\Support\Facades\Auth;

class GetUserAction extends Action
{
    public function run()
    {
        try {
            $data = (new ShowUserResource(Auth::user()))->toArray();

            return $this->responder(
                ShowUserResponder::class,
                $data
            );
        } catch (\Exception $e) {
            return $this->responder(
                ErrorResponder::class,
                $e->getMessage()
            );
        }
    }
}

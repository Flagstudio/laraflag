<?php

namespace App\Http\Controllers\Nova;

use Laravel\Nova\Http\Controllers\ResourceUpdateController as NovaResourceUpdateController;
use Laravel\Nova\Http\Requests\UpdateResourceRequest;

class ResourceUpdateController extends NovaResourceUpdateController
{
    /**
     * Determine if the model has been updated since it was retrieved.
     *
     * @param  \Laravel\Nova\Http\Requests\UpdateResourceRequest $request
     * @param  \Illuminate\Database\Eloquent\Model               $model
     *
     * @return bool
     */
    protected function modelHasBeenUpdatedSinceRetrieval(UpdateResourceRequest $request, $model)
    {
        return false;
    }
}

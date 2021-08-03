<?php

namespace App\Ship\Apiato\Helpers;

use App\Ship\Parents\Transformers\Transformer;

class CallTransformer
{
    use GetCallableInstance;

    public function transformer(...$parameters)
    {
        list($instance, $args) = $this->getInstance(...$parameters);

        if (!($instance instanceof Transformer)) {
            throw new \Exception("Class $parameters[0] not implement Transformer");
        }

        return $instance->transform(...$args);
    }
}

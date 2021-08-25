<?php

namespace App\Containers\User\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class SearchUserInOneSException extends Exception
{
    public $httpStatusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

    public $message = 'An error occurred when searching user in 1C.';

    public $code = 0;
}

<?php

namespace App\Ship\Apiato\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class InvalidTransformerException.
 *
 * @author  Johannes Schobel <johannes.schobel@googlemail.com>
 */
class InvalidArgumentException extends Exception
{
    public $httpStatusCode = SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR;

    public $message = 'Invalid arguments.';
}

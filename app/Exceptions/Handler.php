<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the Throwable types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [

    ];

    /**
     * A list of the inputs that are never flashed for validation Throwables.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an Throwable.
     *
     * @param \Throwable $Throwable
     *
     * @return void
     */
    public function report(Throwable $Throwable)
    {
        parent::report($Throwable);
    }

    /**
     * Render an Throwable into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $Throwable
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $Throwable)
    {
        return parent::render($request, $Throwable);
    }
}

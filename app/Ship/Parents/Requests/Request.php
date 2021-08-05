<?php

namespace App\Ship\Parents\Requests;

use App\Ship\Apiato\Abstracts\Requests\Request as AbstractRequest;

abstract class Request extends AbstractRequest
{

    /**
     * If no custom Transporter is set on the child this will be default.
     *
     * @var string
     */
    protected string $transporter = '';//DataTransporter::class;
}

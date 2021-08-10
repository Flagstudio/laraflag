<?php

namespace App\Ship\Apiato\Abstracts\Requests;

use App\Ship\Apiato\Abstracts\Transporters\Transporter;
use App\Ship\Apiato\Exceptions\MissingTransporterException;
use Illuminate\Foundation\Http\FormRequest as LaravelRequest;

abstract class Request extends LaravelRequest
{
    abstract public function transporter(): string;

    public function transportered(): Transporter
    {
        if (!$this->transporter()) {
            throw new MissingTransporterException;
        }

        return $this->transporter()::fromRequest($this);
    }
}

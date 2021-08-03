<?php

namespace App\Ship\Apiato\Abstracts\Requests;

use App\Ship\Apiato\Abstracts\Transporters\Transporter;
use App\Ship\Apiato\Exceptions\UndefinedTransporterException;
use App;
use Illuminate\Foundation\Http\FormRequest as LaravelRequest;

/**
 * Class Request
 *
 * A.K.A (app/Http/Requests/Request.php)
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
abstract class Request extends LaravelRequest
{
    /**
     * Returns the Transporter (if correctly set)
     *
     * @throws UndefinedTransporterException
     *
     * @return string
     */
//    public function getTransporter()
//    {
//        if ($this->transporter == null) {
//            throw new UndefinedTransporterException();
//        }
//
//        return $this->transporter;
//    }

    /**
     * Transforms the Request into a specified Transporter class.
     *
     * @return Transporter
     */
//    public function toTransporter()
//    {
//        $transporterClass = $this->getTransporter();
//
//        /** @var Transporter $transporter */
//        $transporter = new $transporterClass($this);
//        $transporter->setInstance('request', $this);
//
//        return $transporter;
//    }
}

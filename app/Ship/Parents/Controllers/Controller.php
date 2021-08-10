<?php

namespace App\Ship\Parents\Controllers;

use App\Ship\Apiato\Abstracts\Controllers\WebController as AbstractWebController;
use App\Ship\Traits\CanCallAction;
use App\Ship\Traits\CanCallResponder;

/**
 * Class WebController.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
abstract class Controller extends AbstractWebController
{
    use CanCallAction,
        CanCallResponder;
}

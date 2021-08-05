<?php

namespace App\Ship\Parents\Controllers;

use App\Ship\Apiato\Abstracts\Controllers\WebController as AbstractWebController;
use App\Ship\Traits\CanCallAction;

/**
 * Class WebController.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
abstract class Controller extends AbstractWebController
{
    use CanCallAction;
}

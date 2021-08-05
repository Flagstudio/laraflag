<?php

namespace App\Ship\Parents\Actions;

use App\Ship\Apiato\Abstracts\Actions\SubAction as AbstractSubAction;
use App\Ship\Traits\CanCallTask;

/**
 * Class SubAction.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
abstract class SubAction extends AbstractSubAction
{
    use CanCallTask;
}

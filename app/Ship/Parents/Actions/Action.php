<?php

namespace App\Ship\Parents\Actions;

use App\Ship\Apiato\Abstracts\Actions\Action as AbstractAction;
use App\Ship\Traits\CanCallResponder;
use App\Ship\Traits\CanCallTask;

/**
 * Class Action.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
abstract class Action extends AbstractAction
{
    use CanCallTask,
        CanCallResponder;
}

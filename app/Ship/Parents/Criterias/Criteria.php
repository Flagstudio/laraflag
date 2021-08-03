<?php

namespace App\Ship\Parents\Criterias;

use App\Ship\Apiato\Abstracts\Criterias\Criteria as AbstractCriteria;

/**
 * Class Criteria.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
abstract class Criteria extends AbstractCriteria
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
}

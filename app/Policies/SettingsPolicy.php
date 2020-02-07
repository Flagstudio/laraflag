<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class SettingsPolicy
{
    use HandlesAuthorization;

    public function viewAny()
    {
        return true;
    }

    public function update()
    {
        return true;
    }

    public function view()
    {
        return true;
    }
}

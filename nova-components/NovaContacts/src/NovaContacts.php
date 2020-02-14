<?php

namespace Flagstudio\NovaContacts;

use Laravel\Nova\Card;

class NovaContacts extends Card
{
    public function __construct($component = null)
    {
        parent::__construct($component);

        $this->withMeta([
            'flagstudioInfo' => [
                'testapp' => env('APP_URL'),
                'login' => 'admin',
                'password' => '007',
                'manager' => 'Змазова Ксения',
                'email' => 'zmazova@flagstudio.ru',
                'phone' => '+7 (343) 287-53-70',
            ],
        ]);
    }

    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = '1/3';

    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'nova-contacts';
    }
}

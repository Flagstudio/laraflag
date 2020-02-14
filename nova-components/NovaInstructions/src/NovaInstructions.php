<?php

namespace Flagstudio\NovaInstructions;

use Laravel\Nova\Card;

class NovaInstructions extends Card
{
    public function __construct($component = null)
    {
        parent::__construct($component);

        $this->withMeta([
            'instructions' => [
                [
                    'title' => 'Требования к загрузке изображений',
                    'link' => env('APP_URL'),
                ],
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
        return 'nova-instructions';
    }
}

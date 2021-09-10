<?php

namespace Flagstudio\CustomCard;

use Laravel\Nova\Card;

class CustomCard extends Card
{
    /**
     * @var string
     */
    public $content;

    /**
     * CustomCard constructor.
     *
     * @param string $content
     * @param null|string $component
     */
    public function __construct(string $content, string $width = '1/3', ?string $component = null)
    {
        parent::__construct($component);

        $this->withMeta(['content' => $content]);
        $this->content = $content;
        $this->width = $width;
        $this->component = $component;
    }

    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
//    public $width = '1/3';

    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'custom-card';
    }
}

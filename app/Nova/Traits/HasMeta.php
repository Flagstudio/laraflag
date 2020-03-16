<?php

namespace App\Nova\Traits;

use Laravel\Nova\Fields\Text;
use R64\NovaFields\JSON;

trait HasMeta
{
    /**
     * @param string $jsonColumn
     *
     * @return JSON
     */
    public static function metaTagsFields($jsonColumn = 'meta')
    {
        return JSON::make($jsonColumn, [
            Text::make('Тег <title>', 'tag_title'),
            Text::make('Title', 'title'),
            Text::make('Description', 'description'),
            Text::make('Keywords', 'keywords'),
        ])->fieldClasses('w-full')
            ->hideLabelInDetail()
            ->hideLabelInForms();
    }
}

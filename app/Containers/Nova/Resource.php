<?php

namespace App\Containers\Nova;

use Laravel\Nova\Resource as NovaResource;
use Laravel\Nova\Http\Requests\NovaRequest;
use R64\NovaFields\JSON;
use Emilianotisato\NovaTinyMCE\NovaTinyMCE;
use Laravel\Nova\Fields\Text;

abstract class Resource extends NovaResource
{
    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query;
    }

    /**
     * Build a Scout search query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Laravel\Scout\Builder  $query
     *
     * @return \Laravel\Scout\Builder
     */
    public static function scoutQuery(NovaRequest $request, $query)
    {
        return $query;
    }

    /**
     * Build a "detail" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function detailQuery(NovaRequest $request, $query)
    {
        return parent::detailQuery($request, $query);
    }

    /**
     * Build a "relatable" query for the given resource.
     *
     * This query determines which instances of the model may be attached to other resources.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function relatableQuery(NovaRequest $request, $query)
    {
        return parent::relatableQuery($request, $query);
    }

    /**
     * @param $fields
     * @param string $columnName
     *
     * @return JSON
     */
    public function json($fields, $columnName = 'Fields'): JSON
    {
        return JSON::make($columnName, $fields)
            ->hideLabelInDetail()
            ->hideLabelInForms()
            ->flatten();
    }

    /**
     * @param $displayingName
     * @param null $columnName
     *
     * @return NovaTinyMCE
     */
    public function tiny($displayingName, $columnName = null): NovaTinyMCE
    {
        $columnName = $columnName ?? $displayingName;

        return NovaTinyMCE::make($displayingName, $columnName)
            ->options(config('nova.tinymce_options'));
    }


    /**
     * @param null|string $url
     * @param string $title
     *
     * @return Text
     */
    public function link(string $title, string $url, string $text): Text
    {
        return Text::make($title, fn () => '<a class="no-underline dim text-primary font-bold" href="' . $url . '" target="_blank">' . $text . ' </a>')
            ->exceptOnForms()
            ->asHtml();
    }

    protected static string $identificator = 'id';
    protected function identificator()
    {
        $identificatorName = static::$identificator;
        $identificator = $this->$identificatorName;
        if (!$identificator && $resourceId = request()->resourceId) {
            $identificator = static::$model::find($resourceId)->$identificatorName;
        }
        return $identificator;
    }

    /**
     * @return \Closure
     */
    public static function getHashMediaFunc(): \Closure
    {
        return function ($originalFilename, $extension) {
            return Str::slug(explode(".", $originalFilename)[0]) . '.' . $extension;
        };
    }
}

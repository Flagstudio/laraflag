<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class Settings extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\Settings';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static $group = 'Другое';

    public static function label()
    {
        return 'Настройки';
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function fields(Request $request)
    {
        $defaultFields = [
            ID::make()->sortable(),

            Text::make('Название', 'title')->displayUsing(function ($title) {
                return mb_convert_case($title, MB_CASE_TITLE, 'UTF-8');
            })->onlyOnIndex(),
        ];

        $slug = $this->slug;

        if ($this->slug === null) {
            $resourceId = $request->route('resourceId');
            if ($resourceId === null) {
                $slug = \App\Models\Settings::find($resourceId)->slug;
            }
        }

        //Get fields depending on resource title
        switch ($slug) {
            case \App\Models\Settings::METRICS_SLUG:
                $fields = $this->metricsFields();

                break;
            case \App\Models\Settings::ROBOTS_SLUG:
                $fields = $this->robotsFields();

                break;
            default:
                $fields = [];

                break;
        }

        return array_merge($defaultFields, $fields);
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }

    /**
     * @return array
     */
    private function metricsFields(): array
    {
        return [
            $this->json([
                Textarea::make('Внутри тега head', 'scripts_head'),
                Textarea::make('После открывающего тега body', 'scripts_begin'),
                Textarea::make('Перед закрывающем тегом body', 'scripts_end'),
            ]),
        ];
    }

    /**
     * @return array
     */
    private function robotsFields(): array
    {
        return [
            $this->json([
                Textarea::make('Robots.txt', 'robots')
                    ->rows(10),
            ]),
        ];
    }
}

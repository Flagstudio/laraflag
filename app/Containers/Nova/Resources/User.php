<?php

namespace App\Containers\Nova\Resources;

use App\Containers\Nova\Resource;
use App\Containers\User\Domain\Enums\Sex\SexTitleEnum;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Password;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Containers\User\Domain\Entities\User::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'email',
    ];

    public static $group = [
        'Пользователи',
    ];

    public static function label(): string
    {
        return 'Пользователи';
    }

    public static function singularLabel(): string
    {
        return 'Пользователь';
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Телефон', 'phone')
                ->sortable()
                ->readonly(),

            Text::make('Имя', 'name')
                ->sortable()
                ->rules('required', 'max:21'),

            Text::make('Email')
                ->sortable()
                ->rules('email', 'max:50')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:6')
                ->updateRules('nullable', 'string', 'min:6'),

            Date::make('дата рождения', 'birth'),

            Select::make('Пол', 'sex')
                ->options(SexTitleEnum::labels())
                ->displayUsingLabels(),

            Boolean::make('Получать рекламу и акции', 'allow_ads'),

            Boolean::make('Согласие на хранение и обработку персональных данных', 'allow_privacy')
                ->rules('required')
                ->readonly(),

            Boolean::make('Согласие на геопозиционирование устройства', 'allow_geocoding'),
        ];
    }
}

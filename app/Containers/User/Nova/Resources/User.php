<?php

namespace App\Containers\User\Nova\Resources;

use App\Containers\User\Domain\Enums\Sex\SexTitleEnum;
use App\Ship\Nova\Resource;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class User extends Resource
{
    public static string $model = \App\Containers\User\Domain\Entities\User::class;

    public static $title = 'name';

    public static $search = [
        'id',
        'name',
        'email',
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

            Date::make('дата рождения', 'birthday'),

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

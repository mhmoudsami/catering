<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Boolean;
use MrMonat\Translatable\Translatable;
use Laravel\Nova\Panel;
use Laravel\Nova\Http\Requests\NovaRequest;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;

class Provider extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Provider';

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
        'id','name','description'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Translatable::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Translatable::make('Description')
                ->sortable()
                ->rules('required', 'max:255')
                ->hideFromIndex(),

            Text::make('Responsible Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Responsible Mobile')
                ->sortable()
                ->rules('required', 'max:255'),

            Images::make('Image', 'image')
                ->conversionOnIndexView('thumb')
                ->rules('required'),



            Boolean::make('Active ?' , 'status')->rules('required')->sortable(),

            new Panel('Login Information', [

                Text::make('Email')
                    ->sortable()
                    ->rules('required', 'email', 'max:254')
                    ->creationRules('unique:users,email')
                    ->updateRules('unique:users,email,{{resourceId}}')
                    ->hideFromIndex(),

                Password::make('Password')
                    ->onlyOnForms()
                    ->creationRules('required', 'string', 'min:8')
                    ->updateRules('nullable', 'string', 'min:8'),

            ]),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}

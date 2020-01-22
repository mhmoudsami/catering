<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;
use MrMonat\Translatable\Translatable;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use EricLagarda\NovaEmbed\Embed;
use Laravel\Nova\Fields\BelongsToMany;

class Service extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Service';

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

            BelongsTo::make('Provider')->withoutTrashed(),

            BelongsToMany::make('Requirements'),

            Translatable::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Translatable::make('Description')
                ->sortable()
                ->hideFromIndex()
                ->rules('required'),

            Images::make('Image', 'image')
                ->conversionOnIndexView('thumb')
                ->rules('required'),

            Images::make('Gallery', 'gallery')
                ->hideFromIndex()
                ->conversionOnIndexView('thumb')
                ->rules('required'),

            Embed::make('Video Url')->rules('url')->ajax()->hideFromIndex(),

            Currency::make('Price')->rules('required'),

            Currency::make('Extra Person Cost')->rules('required')->hideFromIndex(),

            Number::make('Capacity')->rules('required')->min(1)->max(1000)->step(1),

            Text::make('Duration')->rules('required'),

            Text::make('Prepare Time')->rules('required'),


            Select::make("Gender")
                ->options([
                    '1' => 'Male',
                    '2' => 'Female',
                ])
                // ->saveAsString()
                // ->saveUncheckedValues()
                // ->displayUncheckedValuesOnIndex()
                // ->displayUncheckedValuesOnDetail()
                ->hideFromIndex(),

            Boolean::make('Active ?' , 'status')->rules('required')->sortable(),
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

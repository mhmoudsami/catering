<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Http\Requests\NovaRequest;

class Order extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Order';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
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

            HasMany::make('OrderNote' , 'comments'),

            Select::make("Status")
                ->sortable()
                ->options(config('catering.order_statuses'))
                ->displayUsingLabels()
                ->onlyOnForms()
                ,
            Text::make("Status")->displayUsing(function ($status) {
                    return view('partials.status-label', [
                        'status' => $status,
                        'label'  => config('catering.order_statuses')[$status]
                    ])->render();
                })
                ->asHtml()
                ->exceptOnForms()
                ,

            Date::make('Date')->rules('required')->sortable()
                ,

            Number::make('Persons Count')->rules('required')->min(1)->max(1000)->step(1)->sortable()
                ,

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255')
                // ->hideFromIndex()
                ,

            Text::make('Mobile')
                ->sortable()
                ->rules('required', 'max:255')
                // ->hideFromIndex()
                ,

            Text::make('Email')
                ->sortable()
                ->rules('required', 'max:255')
                ->hideFromIndex()
                ,

            BelongsTo::make('City')->withoutTrashed()->sortable()
                ,

            Text::make('Address')
                ->sortable()
                ->rules('required', 'max:255')
                ->hideFromIndex()
                ,

            Textarea::make('Notes')
                ->sortable()
                ->rules('required', 'max:255')
                // ->hideFromIndex()
                ,

            Currency::make('Subtotal')->rules('required')->sortable()
                ,

            Currency::make('Total')->rules('required')->sortable()
                ,

            BelongsTo::make('User')->withoutTrashed()->hideFromIndex(),
            BelongsTo::make('Provider')->withoutTrashed()->hideFromIndex(),
            BelongsTo::make('Service')->withoutTrashed()->hideFromIndex(),
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
        return [
            new \App\Nova\Filters\OrderStatus,
        ];
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
        return [
            (new \App\Nova\Actions\ChangeOrderStatus)->canRun(function ($request, $user) {
                return true;
            }),
        ];
    }
}

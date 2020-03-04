<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Comment;

class ContactMessage extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\ContactMessage';

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
        'id','name','email','message'
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
            ID::make()->sortable()->hideFromDetail(),
            
            Select::make("Status")
                ->sortable()
                ->options(config('catering.order_statuses'))
                ->displayUsingLabels()
                ->onlyOnForms()
                ->rules('required')
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
            Text::make(__('Name'))
                ->rules('required'),

            Text::make(__('Email'))
                ->rules('required' , 'email'),

            Text::make(__('Mobile'))
                ->rules('required'),

            Textarea::make(__('Message'))->alwaysShow()
                ->rules('required'),

            // DateTime::make(__('Created At'))->format('MM/DD/YYYY hh:mm a'),
            MorphMany::make('Comments'),
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

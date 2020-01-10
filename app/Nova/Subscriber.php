<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

/**
 * Defines a subscriber for Nova.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Subscriber extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Subscriber::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * Key for the translation group used to get the labels.
     *
     * @var string
     */
    public static $translateKey = 'subscriber';

    /**
     * Default ordering for index query.
     *
     * @var array
     */
    public static $indexDefaultOrder = [
        'created_at' => 'desc',
    ];

    /**
     * The main menu group.
     *
     * @return string
     */
    public static function group()
    {
        return __('nova-group.other');
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = ['name', 'email'];

    /**
     * Get the fields displayed by the resource.
     *
     * @param Request $request
     *
     * @return array
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make(__('subscriber.attributes.name'), 'name')
                ->sortable()
                ->rules('required', 'db_string'),

            Text::make(__('subscriber.attributes.email'), 'email')
                ->sortable()
                ->rules('required', 'email', 'db_string'),

            DateTime::make(__('subscriber.attributes.confirmed_at'), 'confirmed_at')
                ->format(config('constants.format.datetime_moment'))
                ->sortable()
                ->exceptOnForms(),

            DateTime::make(__('subscriber.attributes.created_at'), 'created_at')
                ->format(config('constants.format.datetime_moment'))
                ->sortable()
                ->exceptOnForms(),

            DateTime::make(__('subscriber.attributes.updated_at'), 'updated_at')
                ->format(config('constants.format.datetime_moment'))
                ->sortable()
                ->exceptOnForms(),
        ];
    }
}

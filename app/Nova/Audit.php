<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Text;

/**
 * Defines an audit for Nova.
 */
class Audit extends BaseResource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \OwenIt\Auditing\Models\Audit::class;

    /**
     * Key for the translation group used to get the labels.
     *
     * @var string
     */
    public static $translateKey = 'audit';

    /**
     * The main menu group.
     *
     * @return string
     */
    public static function group()
    {
        return __('nova-group.system');
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [];

    /**
     * The eager loaded relations.
     *
     * @var array
     */
    public static $with = ['user', 'auditable'];

    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title()
    {
        return $this->event . ' - ' . $this->auditable;
    }

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

            MorphTo::make(__('user.singular'), 'user', User::class)
                ->exceptOnForms(),

            Text::make(__('audit.attributes.event'), 'event')
                ->sortable(),

            MorphTo::make(__('audit.attributes.auditable'), 'auditable')
                ->exceptOnForms(),

            Text::make(__('audit.attributes.ip_address'), 'ip_address')
                ->sortable()
                ->onlyOnDetail(),

            Text::make(__('audit.attributes.user_agent'), 'user_agent')
                ->sortable()
                ->onlyOnDetail(),

            Text::make(__('audit.attributes.url'), 'url')
                ->sortable()
                ->onlyOnDetail(),

            Code::make(__('audit.attributes.old_values'), 'old_values')
                ->json()
                ->onlyOnDetail(),

            Code::make(__('audit.attributes.new_values'), 'new_values')
                ->json()
                ->onlyOnDetail(),

            Code::make(__('audit.attributes.tags'), 'tags')
                ->json()
                ->onlyOnDetail(),

            DateTime::make(__('audit.attributes.created_at'), 'created_at')
                ->format(config('constants.format.datetime_moment'))
                ->sortable()
                ->exceptOnForms(),
        ];
    }
}

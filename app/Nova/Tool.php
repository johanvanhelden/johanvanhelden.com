<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use OptimistDigital\NovaSortable\Traits\HasSortableRows;

/**
 * Defines a tool for Nova.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Tool extends BaseResource
{
    use HasSortableRows;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Tool::class;

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
    public static $translateKey = 'tool';

    /**
     * Default ordering for index query.
     *
     * @var array
     */
    public static $indexDefaultOrder = [
        'order' => 'asc',
    ];

    /**
     * The main menu group.
     *
     * @return string
     */
    public static function group()
    {
        return __('nova-group.content');
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = ['name', 'url'];

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

            Image::make(__('tool.attributes.image'), 'image')
                ->rules('image')
                ->creationRules(['required'])
                ->disk('tools')
                ->deletable(false)
                ->prunable(),

            Text::make(__('tool.attributes.name'), 'name')
                ->sortable()
                ->rules('required', 'db_string'),

            Text::make(__('tool.attributes.url'), 'url')
                ->sortable()
                ->rules('nullable', 'url', 'db_string'),

            DateTime::make(__('tool.attributes.publish_at'), 'publish_at')
                ->format(config('constants.format.datetime_moment'))
                ->rules('nullable', 'date_format:' . config('constants.format.datetime_nova'))
                ->sortable(),
        ];
    }
}

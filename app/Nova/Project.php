<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

/**
 * Defines a project for Nova.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Project extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Project::class;

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
    public static $translateKey = 'project';

    /**
     * Default ordering for index query.
     *
     * @var array
     */
    public static $indexDefaultOrder = [
        'publish_at' => 'desc',
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
    public static $search = ['name', 'excerpt', 'content', 'url'];

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

            Text::make(__('project.attributes.name'), 'name')
                ->sortable()
                ->rules('required', 'db_string'),

            Text::make(__('project.attributes.slug'), 'slug')
                ->sortable()
                ->rules('required', 'db_string')
                ->creationRules('unique:projects,slug')
                ->updateRules('unique:projects,slug,{{resourceId}}'),

            Textarea::make(__('project.attributes.excerpt'), 'excerpt')
                ->sortable()
                ->rules('required', 'db_string'),

            Markdown::make(__('project.attributes.content'), 'content')
                ->sortable()
                ->rules('required', 'string'),

            Text::make(__('project.attributes.url'), 'url')
                ->sortable()
                ->rules('nullable', 'url', 'db_string'),

            DateTime::make(__('project.attributes.publish_at'), 'publish_at')
                ->format(config('constants.format.datetime_moment'))
                ->rules('nullable', 'date_format:' . config('constants.format.datetime_nova'))
                ->sortable(),
        ];
    }
}

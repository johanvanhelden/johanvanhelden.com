<?php

declare(strict_types=1);

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class Project extends BaseResource
{
    public static string $model = \App\Models\Project::class;

    /** @var string */
    public static $title = 'name';

    public static string $translateKey = 'project';

    public static array $indexDefaultOrder = [
        'publish_at' => 'desc',
    ];

    public static function group(): string
    {
        return __('nova-group.content');
    }

    /** @var array */
    public static $search = ['name', 'excerpt', 'content', 'url'];

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
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
                ->format(config('format.datetime_moment'))
                ->rules('nullable', 'date_format:' . config('format.datetime_nova'))
                ->sortable(),
        ];
    }
}

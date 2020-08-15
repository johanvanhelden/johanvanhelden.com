<?php

declare(strict_types=1);

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use OptimistDigital\NovaSortable\Traits\HasSortableRows;

class Tool extends BaseResource
{
    use HasSortableRows;

    public static string $model = \App\Models\Tool::class;

    /** @var string */
    public static $title = 'name';

    public static string $translateKey = 'tool';

    public static array $indexDefaultOrder = [
        'order' => 'asc',
    ];

    public static function group(): string
    {
        return __('nova-group.content');
    }

    /** @var array */
    public static $search = ['name', 'url'];

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function fields(Request $request): array
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
                ->format(config('format.datetime_moment'))
                ->rules('nullable', 'date_format:' . config('format.datetime_nova'))
                ->sortable(),
        ];
    }
}

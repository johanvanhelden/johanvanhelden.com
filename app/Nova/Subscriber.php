<?php

declare(strict_types=1);

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class Subscriber extends BaseResource
{
    public static string $model = \App\Models\Subscriber::class;

    /** @var string */
    public static $title = 'name';

    public static string $translateKey = 'subscriber';

    public static array $indexDefaultOrder = [
        'created_at' => 'desc',
    ];

    public static function group(): string
    {
        return __('nova-group.other');
    }

    /** @var array */
    public static $search = ['name', 'email'];

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
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
                ->format(config('format.datetime_moment'))
                ->sortable()
                ->exceptOnForms(),

            DateTime::make(__('subscriber.attributes.created_at'), 'created_at')
                ->format(config('format.datetime_moment'))
                ->sortable()
                ->exceptOnForms(),

            DateTime::make(__('subscriber.attributes.updated_at'), 'updated_at')
                ->format(config('format.datetime_moment'))
                ->sortable()
                ->exceptOnForms(),
        ];
    }
}

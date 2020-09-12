<?php

declare(strict_types=1);

namespace App\Nova;

use App\Enums\Activity\Event;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Text;

class Activity extends BaseResource
{
    public static string $model = \App\Models\Activity::class;

    public static string $translateKey = 'activity';

    public static function group(): string
    {
        return __('nova-group.system');
    }

    /** @var array */
    public static $search = [];

    /** @var array */
    public static $with = ['causer', 'subject'];

    public function title(): string
    {
        return $this->description;
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            MorphTo::make(__('activity.attributes.causer'), 'causer', User::class)
                ->exceptOnForms(),

            Text::make(__('activity.attributes.description'), 'description')
                ->displayUsing(function ($value) {
                    return Event::display($value);
                })
                ->sortable(),

            MorphTo::make(__('activity.attributes.subject'), 'subject')
                ->exceptOnForms(),

            Code::make(__('activity.attributes.properties'), 'properties')
                ->json()
                ->onlyOnDetail(),

            DateTime::make(__('activity.attributes.created_at'), 'created_at')
                ->format(config('format.datetime_moment'))
                ->sortable()
                ->exceptOnForms(),
        ];
    }
}

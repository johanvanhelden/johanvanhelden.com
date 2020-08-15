<?php

declare(strict_types=1);

namespace App\Nova;

use App\Enums\Audit\Event;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Text;

class Audit extends BaseResource
{
    public static string $model = \App\Models\Audit::class;

    public static string $translateKey = 'audit';

    public static function group(): string
    {
        return __('nova-group.system');
    }

    /** @var array */
    public static $search = [];

    /** @var array */
    public static $with = ['user', 'auditable'];

    public function title(): string
    {
        return $this->event . ' - ' . $this->auditable;
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            MorphTo::make(__('user.singular'), 'user', User::class)
                ->exceptOnForms(),

            Text::make(__('audit.attributes.event'), 'event')
                ->displayUsing(function ($value) {
                    return Event::display($value);
                })
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
                ->format(config('format.datetime_moment'))
                ->sortable()
                ->exceptOnForms(),
        ];
    }
}

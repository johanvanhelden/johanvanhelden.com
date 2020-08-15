<?php

declare(strict_types=1);

namespace App\Nova;

use App\Nova\Actions\ClearPermissionsCache;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphedByMany;
use Laravel\Nova\Fields\Text;

class Permission extends BaseResource
{
    public static string $model = \Spatie\Permission\Models\Permission::class;

    /** @var string */
    public static $title = 'name';

    public static string $translateKey = 'permission';

    public static function group(): string
    {
        return __('nova-group.users');
    }

    /** @var array */
    public static $search = ['name'];

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make(__('permission.attributes.name'), 'name')
                ->sortable()
                ->rules('required', 'db_string')
                ->creationRules('unique:permissions,name')
                ->updateRules('unique:permissions,name,{{resourceId}}'),

            BelongsToMany::make(__('role.plural'), 'roles', Role::class),
            MorphedByMany::make(__('user.plural'), 'users', User::class),
        ];
    }

    public function actions(Request $request): array
    {
        return [
            (new ClearPermissionsCache())
                ->canSee(function ($request) {
                    return $request->user()->can('manage-permissions');
                })
                ->canRun(function ($request) {
                    return $request->user()->can('manage-permissions');
                }),
        ];
    }
}

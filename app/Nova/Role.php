<?php

declare(strict_types=1);

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphedByMany;
use Laravel\Nova\Fields\Text;

class Role extends BaseResource
{
    public static string $model = \Spatie\Permission\Models\Role::class;

    /** @var string */
    public static $title = 'name';

    public static string $translateKey = 'role';

    public static function group(): string
    {
        return __('nova-group.users');
    }

    /** @var array */
    public static $search = ['name'];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make(__('role.attributes.name'), 'name')
                ->sortable()
                ->rules('required', 'db_string')
                ->creationRules('unique:roles,name')
                ->updateRules('unique:roles,name,{{resourceId}}'),

            BelongsToMany::make(__('permission.plural'), 'permissions', Permission::class),
            MorphedByMany::make(__('user.plural'), 'users', User::class),
        ];
    }
}

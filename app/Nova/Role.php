<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphedByMany;
use Laravel\Nova\Fields\Text;

/**
 * Defines a role for Nova.
 */
class Role extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Spatie\Permission\Models\Role::class;

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
    public static $translateKey = 'role';

    /**
     * The main menu group.
     *
     * @return string
     */
    public static function group()
    {
        return __('nova-group.users');
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = ['name'];

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

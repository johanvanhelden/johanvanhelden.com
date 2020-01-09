<?php

namespace App\Nova;

use App\Nova\Actions\ClearPermissionsCache;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphedByMany;
use Laravel\Nova\Fields\Text;

/**
 * Defines a permission for Nova.
 */
class Permission extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Spatie\Permission\Models\Permission::class;

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
    public static $translateKey = 'permission';

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

            Text::make(__('permission.attributes.name'), 'name')
                ->sortable()
                ->rules('required', 'string', 'db_string')
                ->creationRules('unique:permissions,name')
                ->updateRules('unique:permissions,name,{{resourceId}}'),

            BelongsToMany::make(__('role.plural'), 'roles', Role::class),
            MorphedByMany::make(__('user.plural'), 'users', User::class),
        ];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param Request $request
     *
     * @return array
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function actions(Request $request)
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

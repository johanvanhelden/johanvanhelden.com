<?php

namespace App\Nova;

use App\Nova\Actions\SendSetAccountPassword;
use App\Nova\Metrics\NewUsers;
use App\Nova\Metrics\UsersPerDay;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use NovaAttachMany\AttachMany;

/**
 * Defines a user for Nova.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\User::class;

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
    public static $translateKey = 'user';

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
    public static $search = ['name', 'email'];

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

            Gravatar::make(),

            Text::make(__('user.attributes.name'), 'name')
                ->sortable()
                ->rules('required', 'db_string'),

            Text::make(__('user.attributes.email'), 'email')
                ->sortable()
                ->rules('required', 'email', 'db_string')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make(__('user.attributes.password'), 'password')
                ->onlyOnForms()
                ->rules('nullable', 'string', 'strong_password'),

            DateTime::make(__('user.attributes.created_at'), 'created_at')
                ->format(config('constants.format.datetime_moment'))
                ->sortable()
                ->exceptOnForms(),

            DateTime::make(__('user.attributes.email_verified_at'), 'email_verified_at')
                ->rules('required', 'date_format:' . config('constants.format.datetime_nova'))
                ->format(config('constants.format.datetime_moment'))
                ->sortable(),

            AttachMany::make(__('role.plural'), 'roles', Role::class)
                ->rules('min:1'),

            MorphToMany::make(__('role.plural'), 'roles', Role::class),
            MorphToMany::make(__('permission.plural'), 'permissions', Permission::class),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param Request $request
     *
     * @return array
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function cards(Request $request)
    {
        return [
            new NewUsers(),
            new UsersPerDay(),
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
            new SendSetAccountPassword(),
        ];
    }
}

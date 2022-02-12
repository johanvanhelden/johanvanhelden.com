<?php

declare(strict_types=1);

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

class User extends BaseResource
{
    public static string $model = \App\Models\User::class;

    /** @var string */
    public static $title = 'name';

    public static string $translateKey = 'user';

    public static function group(): string
    {
        return __('nova-group.users');
    }

    /** @var array */
    public static $search = ['name', 'email'];

    public function fields(Request $request): array
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
                ->format(config('format.datetime_moment'))
                ->sortable()
                ->exceptOnForms(),

            DateTime::make(__('user.attributes.email_verified_at'), 'email_verified_at')
                ->rules('required', 'date_format:' . config('format.datetime_nova'))
                ->format(config('format.datetime_moment'))
                ->sortable(),

            AttachMany::make(__('role.plural'), 'roles', Role::class)
                ->rules('min:1'),

            MorphToMany::make(__('role.plural'), 'roles', Role::class),
            MorphToMany::make(__('permission.plural'), 'permissions', Permission::class),
        ];
    }

    public function cards(Request $request): array
    {
        return [
            new NewUsers(),
            new UsersPerDay(),
        ];
    }

    public function actions(Request $request): array
    {
        return [
            new SendSetAccountPassword(),
        ];
    }
}

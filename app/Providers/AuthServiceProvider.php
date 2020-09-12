<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\Models\User::class       => \App\Policies\UserPolicy::class,
        \App\Models\Project::class    => \App\Policies\ProjectPolicy::class,
        \App\Models\Tool::class       => \App\Policies\ToolPolicy::class,
        \App\Models\Subscriber::class => \App\Policies\SubscriberPolicy::class,

        \Laravel\Nova\Actions\ActionEvent::class    => \App\Policies\ActionEventPolicy::class,
        \Spatie\Activitylog\Models\Activity::class  => \App\Policies\ActivityPolicy::class,
        \Spatie\Permission\Models\Permission::class => \App\Policies\PermissionPolicy::class,
        \Spatie\Permission\Models\Role::class       => \App\Policies\RolePolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}

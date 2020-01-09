<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * Default auth service provider.
 */
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

        \OwenIt\Auditing\Models\Audit::class        => \App\Policies\AuditPolicy::class,
        \Spatie\Permission\Models\Permission::class => \App\Policies\PermissionPolicy::class,
        \Spatie\Permission\Models\Role::class       => \App\Policies\RolePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}

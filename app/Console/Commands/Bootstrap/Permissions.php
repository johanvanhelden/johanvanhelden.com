<?php

namespace App\Console\Commands\Bootstrap;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Bootstraps the permissions.
 */
class Permissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bootstrap:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bootstraps the permissions.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Bootstrapping permissions...');

        app()['cache']->forget('spatie.permission.cache');

        foreach (config('defaults.roles') as $roleName => $permissions) {
            $role = Role::where('name', $roleName)->first();
            if (empty($role)) {
                $role = Role::create(['name' => $roleName]);
            }

            foreach ($permissions as $permissionName) {
                $permission = Permission::where('name', $permissionName)->first();
                if (empty($permission)) {
                    $permission = Permission::create(['name' => $permissionName]);
                }
            }

            $role->givePermissionTo($permissions);
        }

        $this->deleteDeprecatedPermissions();

        $this->info('Bootstrapping permissions done');
    }

    /**
     * Removes permissions that are no longer used.
     */
    private function deleteDeprecatedPermissions()
    {
        $rolesWithPermissions = config('defaults.roles');
        $permissions = Arr::flatten($rolesWithPermissions);

        Permission::whereNotIn('name', $permissions)->each(function ($permission) {
            $permission->delete();
        });
    }
}

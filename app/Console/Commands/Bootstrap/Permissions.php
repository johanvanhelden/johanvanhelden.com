<?php

declare(strict_types=1);

namespace App\Console\Commands\Bootstrap;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Permissions extends Command
{
    /** @var string */
    protected $signature = 'bootstrap:permissions';

    /** @var string */
    protected $description = 'Bootstraps the permissions.';

    public function handle(): void
    {
        $this->info('Bootstrapping permissions...');

        App::get('cache')->forget('spatie.permission.cache');

        foreach (config('bootstrap.roles') as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            foreach ($permissions as $permissionName) {
                Permission::firstOrCreate(['name' => $permissionName]);
            }

            $role->givePermissionTo($permissions);
        }

        $this->deleteDeprecatedPermissions();

        $this->info('Bootstrapping permissions done');
    }

    private function deleteDeprecatedPermissions(): void
    {
        $rolesWithPermissions = config('bootstrap.roles');
        $permissions = Arr::flatten($rolesWithPermissions);

        Permission::whereNotIn('name', $permissions)->delete();
    }
}

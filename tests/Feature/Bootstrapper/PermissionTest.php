<?php

namespace Tests\Feature\Bootstrapper;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Tests to ensure the permission bootstrapper is working properly.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class PermissionTest extends BaseBootstrapperTest
{
    /** @test */
    public function it_works()
    {
        $this->artisan('bootstrap:permissions')
            ->expectsOutput('Bootstrapping permissions...')
            ->expectsOutput('Bootstrapping permissions done')
            ->assertExitCode(0);
    }

    /** @test */
    public function permissions_are_created()
    {
        $this->artisan('bootstrap:permissions');

        $this->assertDatabaseHas('permissions', [
            'name' => 'test-admin-permission',
        ]);

        $this->assertDatabaseHas('permissions', [
            'name' => 'test-user-permission',
        ]);
    }

    /** @test */
    public function deprecated_permissions_are_deleted()
    {
        Permission::create(['name' => 'deprecated-permission']);

        $this->artisan('bootstrap:permissions');

        $this->assertDatabaseMissing('permissions', [
            'name' => 'deprecated-permission',
        ]);
    }

    /** @test */
    public function roles_are_given_permissions()
    {
        $this->artisan('bootstrap:permissions');

        $role = Role::where('name', 'admin')->first();
        $permission = Permission::where('name', 'test-admin-permission')->first();

        $this->assertDatabaseHas('role_has_permissions', [
            'permission_id' => $permission->id,
            'role_id'       => $role->id,
        ]);
    }
}

<?php

declare(strict_types=1);

namespace Tests\Feature\Bootstrapper;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionTest extends BaseBootstrapperTest
{
    /** @test */
    public function it_works(): void
    {
        $this->artisan('bootstrap:permissions')

            ->expectsOutput('Bootstrapping permissions...')
            ->expectsOutput('Bootstrapping permissions done')
            ->assertSuccessful();
    }

    /** @test */
    public function permissions_are_created(): void
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
    public function deprecated_permissions_are_deleted(): void
    {
        Permission::create(['name' => 'deprecated-permission']);

        $this->artisan('bootstrap:permissions');

        $this->assertDatabaseMissing('permissions', [
            'name' => 'deprecated-permission',
        ]);
    }

    /** @test */
    public function roles_are_given_permissions(): void
    {
        $this->artisan('bootstrap:permissions');

        $role = Role::where('name', 'admin')->first();
        $permission = Permission::where('name', 'test-admin-permission')->first();

        $this->assertDatabaseHas('role_has_permissions', [
            'permission_id' => $permission->id,
            'role_id'       => $role->id,
        ]);
    }

    /** @test */
    public function the_cache_is_cleared_during_the_bootstrapping(): void
    {
        $this->app->get('cache')->set('spatie.permission.cache', '::initial-cache::');

        $this->artisan('bootstrap:permissions');

        $this->assertEmpty($this->app->get('cache')->get('spatie.permission.cache'));
    }
}

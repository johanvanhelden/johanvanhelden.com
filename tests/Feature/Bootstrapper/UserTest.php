<?php

namespace Tests\Feature\Bootstrapper;

use App\Models\User;
use Spatie\Permission\Models\Role;

/**
 * Tests to ensure the user bootstrapper is working properly.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class UserTest extends BaseBootstrapperTest
{
    /** @test */
    public function it_works()
    {
        $this->artisan('bootstrap:users')
            ->expectsOutput('Bootstrapping users...')
            ->expectsOutput('Bootstrapping users done')
            ->assertExitCode(0);
    }

    /** @test */
    public function the_users_are_created()
    {
        $this->artisan('bootstrap:users');

        $this->assertDatabaseHas('users', [
            'name'  => 'Production User',
            'email' => 'at@production.com',
        ]);

        $this->assertDatabaseHas('users', [
            'name'  => 'Not Production User',
            'email' => 'not@production.com',
        ]);
    }

    /** @test */
    public function users_are_given_roles()
    {
        $this->artisan('bootstrap:users');

        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();
        $adminUser = User::where('email', 'at@production.com')->first();
        $user = User::where('email', 'not@production.com')->first();

        $this->assertDatabaseHas('model_has_roles', [
            'model_id' => $adminUser->id,
            'role_id'  => $adminRole->id,
        ]);

        $this->assertDatabaseHas('model_has_roles', [
            'model_id' => $adminUser->id,
            'role_id'  => $userRole->id,
        ]);

        $this->assertDatabaseHas('model_has_roles', [
            'model_id' => $user->id,
            'role_id'  => $userRole->id,
        ]);

        $this->assertDatabaseMissing('model_has_roles', [
            'model_id' => $user->id,
            'role_id'  => $adminRole->id,
        ]);
    }
}

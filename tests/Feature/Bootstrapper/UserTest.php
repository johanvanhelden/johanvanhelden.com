<?php

declare(strict_types=1);

namespace Tests\Feature\Bootstrapper;

use App\Models\User;
use Spatie\Permission\Models\Role;

class UserTest extends BaseBootstrapperTest
{
    /** @test */
    public function it_works(): void
    {
        $this->artisan('bootstrap:users')

            ->expectsOutput('Bootstrapping users...')
            ->expectsOutput('Bootstrapping users done')
            ->assertSuccessful();
    }

    /** @test */
    public function the_users_are_created(): void
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
    public function non_production_users_are_skipped_on_production(): void
    {
        $this->app['env'] = 'production';

        $this->artisan('bootstrap:users');

        $this->assertDatabaseMissing('users', [
            'name'  => 'Not Production User',
            'email' => 'not@production.com',
        ]);
    }

    /** @test */
    public function users_are_given_roles(): void
    {
        $this->artisan('bootstrap:users');

        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();
        $adminUser = User::whereEmail('at@production.com')->first();
        $user = User::whereEmail('not@production.com')->first();

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

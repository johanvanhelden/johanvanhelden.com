<?php

namespace Tests\Feature\Nova\User;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Tests\Helpers\User as UserHelper;
use Tests\TestCase;

/**
 * Tests to ensure the users can be created properly in Nova.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class CreateTest extends TestCase
{
    /** @test */
    public function an_admin_can_create_it()
    {
        $user = factory(User::class)->make();
        $role = Role::first();

        $this
            ->actingAs(UserHelper::getAdmin())
            ->post('/nova-api/users', array_merge($user->toArray(), [
                'role' => $role->id,
            ]));

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'name'  => $user->name,
        ]);
    }

    /** @test */
    public function a_user_can_not_create_it()
    {
        $user = factory(User::class)->make();
        $role = Role::first();

        $response = $this
            ->actingAs(UserHelper::getUser())
            ->post('/nova-api/users', array_merge($user->toArray(), [
                'role' => $role->id,
            ]));

        $response->assertForbidden();
        $this->assertDatabaseMissing('users', [
            'email' => $user->email,
            'name'  => $user->name,
        ]);
    }
}

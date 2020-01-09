<?php

namespace Tests\Feature\Nova\Role;

use Tests\Helpers\User;
use Tests\TestCase;

/**
 * Tests to ensure the roles can be created properly in Nova.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class CreateTest extends TestCase
{
    /** @test */
    public function an_admin_can_create_it()
    {
        $roleName = 'test-role';

        $this
            ->actingAs(User::getAdmin())
            ->post('/nova-api/roles', [
                'name' => $roleName,
            ]);

        $this->assertDatabaseHas('roles', [
            'name' => $roleName,
        ]);
    }

    /** @test */
    public function a_user_can_not_create_it()
    {
        $roleName = 'test-role';

        $response = $this
            ->actingAs(User::getUser())
            ->post('/nova-api/roles', [
                'name' => $roleName,
            ]);

        $response->assertForbidden();
        $this->assertDatabaseMissing('roles', [
            'name' => $roleName,
        ]);
    }
}

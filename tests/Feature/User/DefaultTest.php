<?php

declare(strict_types=1);

namespace Tests\Feature\User;

use Tests\TestCase;

class DefaultTest extends TestCase
{
    /** @test */
    public function the_default_users_are_present(): void
    {
        foreach (config('defaults.users') as $user) {
            $this->assertDatabaseHas('users', [
               'name'  => $user['data']['name'],
               'email' => $user['data']['email'],
            ]);
        }
    }

    /** @test */
    public function the_default_roles_are_present(): void
    {
        foreach (array_keys(config('defaults.roles')) as $role) {
            $this->assertDatabaseHas('roles', [
               'name' => $role,
            ]);
        }
    }
}

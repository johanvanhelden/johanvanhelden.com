<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use Laravel\Nova\Nova;
use Tests\TestCase;

class AccessTest extends TestCase
{
    /** @test */
    public function a_user_can_not_access_nova(): void
    {
        $user = User::factory()->create()->assignRole('user');

        $this
            ->post(route('login'), [
                'email'    => $user->email,
                'password' => 'password',
            ])

            ->assertRedirect(url(config('nova.path')));

        $this->assertAuthenticatedAs($user);

        $this
            ->getJson(Nova::path())

            ->assertForbidden();
    }

    /** @test */
    public function a_visitor_can_not_access_nova(): void
    {
        $this
            ->followingRedirects()
            ->getJson(Nova::path())

            ->assertUnauthorized();
    }

    /** @test */
    public function an_admin_can_access_nova(): void
    {
        $this
            ->actingAs($this->admin)
            ->followingRedirects()
            ->get(Nova::path())

            ->assertViewIs('nova::router');
    }
}

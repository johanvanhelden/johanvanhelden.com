<?php

namespace Tests\Feature\Auth;

use Laravel\Nova\Nova;
use Tests\Helpers\User;
use Tests\TestCase;

/**
 * Tests to ensure users without proper access can not enter certain areas of the app.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class AccessTest extends TestCase
{
    /** @test */
    public function a_user_can_not_access_nova()
    {
        $user = User::getUser();

        $response = $this->post(route('login'), [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);

        $response = $this->get(Nova::path());

        $response->assertStatus(403);
    }

    /** @test */
    public function a_visitor_can_not_access_nova()
    {
        $response = $this
            ->followingRedirects()
            ->get(Nova::path());

        $response
            ->assertViewIs('auth.login');
    }

    /** @test */
    public function an_admin_can_access_nova()
    {
        $response = $this
            ->actingAs(User::getAdmin())
            ->followingRedirects()
            ->get(Nova::path());

        $response
            ->assertViewIs('nova::router');
    }
}

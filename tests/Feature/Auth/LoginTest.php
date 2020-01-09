<?php

namespace Tests\Feature\Auth;

use Tests\Helpers\User;
use Tests\TestCase;

/**
 * Tests to ensure the login module is functioning properly.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class LoginTest extends TestCase
{
    /** @test */
    public function a_visitor_can_view_the_page()
    {
        $response = $this->get(route('login'));

        $response->assertViewIs('auth.login');
    }

    /** @test */
    public function an_admin_can_login()
    {
        $admin = User::getAdmin();

        $this->post(route('login'), [
            'email'    => $admin->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($admin);
    }

    /** @test */
    public function a_user_can_login()
    {
        $user = User::getUser();

        $this->post(route('login'), [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function with_invalid_credentials_results_in_an_error()
    {
        $response = $this->post(route('login'), [
            'email'    => 'fake@address.com',
            'password' => 'sup3rduperfake!',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'), 'The session does not contain the old email address.');
        $this->assertFalse(session()->hasOldInput('password'), 'The session contains the old password.');
        $this->assertGuest();
    }
}

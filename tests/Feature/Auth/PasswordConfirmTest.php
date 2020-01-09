<?php

namespace Tests\Feature\Auth;

use Tests\Helpers\User;
use Tests\TestCase;

/**
 * Tests to ensure the password confirmation module is functioning properly.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class PasswordConfirmTest extends TestCase
{
    /** @test */
    public function a_user_can_view_the_page()
    {
        $response = $this->actingAs(User::getUser())
            ->get(route('password.confirm'));

        $response->assertViewIs('auth.passwords.confirm');
    }

    /** @test */
    public function a_user_password_gets_confirmed()
    {
        $user = User::getUser();

        $this->actingAs($user)
            ->get(route('page.home'));

        $confirmedAt = session()->get('auth.password_confirmed_at');

        $this->actingAs($user)
            ->post(route('password.confirm'), ['password' => 'password']);

        $this->assertNotEquals(
            $confirmedAt,
            session()->get('auth.password_confirmed_at')
        );
    }
}

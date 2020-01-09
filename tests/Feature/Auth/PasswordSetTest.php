<?php

namespace Tests\Feature\Auth;

use App\Models\NewPassword;
use Tests\Helpers\User;
use Tests\TestCase;

/**
 * Tests to ensure the password set module is functioning properly.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class PasswordSetTest extends TestCase
{
    /** @test */
    public function a_visitor_can_view_the_page()
    {
        $user = User::getUser();
        $token = NewPassword::createToken($user);

        $response = $this->get(route('password-set.show', ['token' => $token]));

        $response->assertViewIs('auth.passwords.set');
    }

    /** @test */
    public function a_user_can_set_his_password()
    {
        $user = User::getUser();
        $token = NewPassword::createToken($user);
        $newPassword = 'Mynewpassw0rd!';

        $this
            ->from(route('password-set.show', [
                'token' => $token,
            ]))
            ->post(route('password-set.post'), [
                'email'                 => $user->email,
                'token'                 => $token,
                'password'              => $newPassword,
                'password_confirmation' => $newPassword,
            ]);

        $this->post(route('login'), [
            'email'    => $user->email,
            'password' => $newPassword,
        ]);

        $this->assertAuthenticatedAs($user);
    }
}

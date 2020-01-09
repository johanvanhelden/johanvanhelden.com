<?php

namespace Tests\Feature\Auth;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\Helpers\User as User;
use Tests\TestCase;

/**
 * Tests to ensure the forgot password module is functioning properly.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class ForgotPasswordTest extends TestCase
{
    /** @test */
    public function a_visitor_can_view_the_page()
    {
        $response = $this->get(route('password.request'));

        $response->assertViewIs('auth.passwords.email');
    }

    /** @test */
    public function an_invalid_email_shows_a_generic_message()
    {
        Notification::fake();

        $response = $this
            ->followingRedirects()
            ->from(route('password.request'))
            ->post(route('password.email'), [
                'email' => 'fake@user.com',
            ]);

        $response->assertSee(__('auth.message.forgotten_status', ['email' => 'fake@user.com']));
    }

    /** @test */
    public function a_link_can_be_requested_for_a_valid_user()
    {
        Notification::fake();

        $user = User::getUser();

        $response = $this
            ->followingRedirects()
            ->from(route('password.request'))
            ->post(route('password.email'), [
                'email' => $user->email,
            ]);

        $response->assertSee(__('auth.message.forgotten_status', ['email' => $user->email]));

        $token = DB::table('password_resets')->first();
        $this->assertNotNull($token);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($token) {
            return Hash::check($notification->token, $token->token) === true;
        });
    }

    /** @test */
    public function a_user_can_reset_his_password()
    {
        $user = User::getUser();
        $token = Password::broker()->createToken($user);
        $newPassword = 'Mynewpassw0rd!';

        $this
            ->from(route('password.reset', [
                'token' => $token,
            ]))
            ->post(route('password.update'), [
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

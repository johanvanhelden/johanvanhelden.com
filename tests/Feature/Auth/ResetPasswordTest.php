<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    /** @test */
    public function a_visitor_can_view_the_page(): void
    {
        $this
            ->get(route('password.reset', 'test-token-123'))

            ->assertOk();
    }

    /** @test */
    public function the_page_contains_the_token(): void
    {
        $this
            ->get(route('password.reset', 'test-token-123'))

            ->assertSee('test-token-123');
    }

    /** @test */
    public function the_page_contains_the_email(): void
    {
        $this
            ->get(route('password.reset', ['test-token-123', 'email' => 'test@email.com']))

            ->assertSee('test@email.com');
    }

    /** @test */
    public function a_user_can_not_set_a_password_with_an_invalid_token(): void
    {
        $user = factory(User::class)->state('user')->create();
        $newPassword = 'Mynewpassw0rd!';

        $this
            ->from(route('password.reset', [
                'token' => 'test-token',
            ]))
            ->postJson(route('password.update'), [
                'email'                 => $user->email,
                'token'                 => 'test-token',
                'password'              => $newPassword,
                'password_confirmation' => $newPassword,
            ])

            ->assertJsonValidationErrors(['email' => __('passwords.token')]);
    }

    /** @test */
    public function a_user_can_not_reset_a_password_with_a_token_for_a_different_user(): void
    {
        $user = factory(User::class)->state('user')->create();
        $tokenUser = factory(User::class)->state('user')->create();
        $newPassword = 'Mynewpassw0rd!';

        /** @var \Illuminate\Auth\Passwords\PasswordBroker */
        $broker = Password::broker();
        $token = $broker->createToken($tokenUser);

        $this
            ->from(route('password.reset', [
                'token' => $token,
            ]))
            ->postJson(route('password.update'), [
                'email'                 => $user->email,
                'token'                 => $token,
                'password'              => $newPassword,
                'password_confirmation' => $newPassword,
            ])

            ->assertJsonValidationErrors(['email' => __('passwords.token')]);
    }

    /** @test */
    public function a_user_can_not_set_a_password_with_an_invalid_email(): void
    {
        $user = factory(User::class)->state('user')->create();
        $newPassword = 'Mynewpassw0rd!';

        /** @var \Illuminate\Auth\Passwords\PasswordBroker */
        $broker = Password::broker();
        $token = $broker->createToken($user);

        $this
            ->from(route('password.reset', [
                'token' => $token,
            ]))
            ->postJson(route('password.update'), [
                'email'                 => 'test@email.com',
                'token'                 => $token,
                'password'              => $newPassword,
                'password_confirmation' => $newPassword,
            ])

            ->assertJsonValidationErrors(['email' => __('passwords.token')]);
    }

    /** @test */
    public function a_user_can_reset_his_password(): void
    {
        $user = factory(User::class)->state('user')->create();
        $newPassword = 'Mynewpassw0rd!';

        /** @var \Illuminate\Auth\Passwords\PasswordBroker */
        $broker = Password::broker();
        $token = $broker->createToken($user);

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

        $this
            ->post(route('login'), [
                'email'    => $user->email,
                'password' => $newPassword,
            ])

            ->assertRedirect(url(config('nova.path')));

        $this->assertAuthenticatedAs($user);
    }
}

<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\NewPassword;
use App\Models\User;
use Tests\TestCase;

class SetPasswordTest extends TestCase
{
    /** @test */
    public function a_visitor_can_view_the_page_with_a_token(): void
    {
        $this
            ->get(route('password-set.show', ['token' => 'random-token']))

            ->assertOk();
    }

    /** @test */
    public function a_user_can_not_set_a_password_with_an_invalid_token(): void
    {
        $user = factory(User::class)->state('user')->create();
        $newPassword = 'Mynewpassw0rd!';

        $this
            ->from(route('password-set.show', [
                'token' => 'test-token',
            ]))
            ->postJson(route('password-set.post'), [
                'email'                 => $user->email,
                'token'                 => 'test-token',
                'password'              => $newPassword,
                'password_confirmation' => $newPassword,
            ])

            ->assertJsonValidationErrors(['email' => __('passwords.token')]);
    }

    /** @test */
    public function a_user_can_not_set_a_password_with_an_invalid_email(): void
    {
        $user = factory(User::class)->state('user')->create();
        $token = NewPassword::createToken($user);
        $newPassword = 'Mynewpassw0rd!';

        $this
            ->from(route('password-set.show', [
                'token' => $token,
            ]))
            ->postJson(route('password-set.post'), [
                'email'                 => 'test@email.com',
                'token'                 => $token,
                'password'              => $newPassword,
                'password_confirmation' => $newPassword,
            ])

            ->assertJsonValidationErrors(['email' => __('passwords.token')]);
    }

    /** @test */
    public function a_user_can_not_set_a_password_with_a_token_for_a_different_user(): void
    {
        $user = factory(User::class)->state('user')->create();
        $tokenUser = factory(User::class)->state('user')->create();
        $newPassword = 'Mynewpassw0rd!';
        $token = NewPassword::createToken($tokenUser);

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
    public function a_user_can_set_his_password(): void
    {
        $user = factory(User::class)->state('user')->create();
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

        $this
            ->post(route('login'), [
                'email'    => $user->email,
                'password' => $newPassword,
            ])

            ->assertRedirect(url(config('nova.path')));

        $this->assertAuthenticatedAs($user);
    }
}

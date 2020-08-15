<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    /** @test */
    public function a_visitor_can_view_the_page(): void
    {
        $this
            ->get(route('password.request'))

            ->assertOk();
    }

    /** @test */
    public function an_invalid_email_shows_a_generic_message(): void
    {
        Notification::fake();

        $this
            ->followingRedirects()
            ->from(route('password.request'))
            ->post(route('password.email'), [
                'email' => 'fake@user.com',
            ])

            ->assertSee(__('auth.message.forgotten_status', ['email' => 'fake@user.com']));
    }

    /** @test */
    public function a_link_can_be_requested_for_a_valid_user(): void
    {
        Notification::fake();

        $user = factory(User::class)->state('user')->create();

        $this
            ->followingRedirects()
            ->from(route('password.request'))
            ->post(route('password.email'), [
                'email' => $user->email,
            ])

            ->assertSee(__('auth.message.forgotten_status', ['email' => $user->email]));

        $token = DB::table('password_resets')->first();
        $this->assertNotNull($token);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($token) {
            return Hash::check($notification->token, $token->token) === true;
        });
    }
}

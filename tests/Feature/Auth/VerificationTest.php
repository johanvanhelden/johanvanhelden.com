<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class VerificationTest extends TestCase
{
    /** @test */
    public function the_verification_page_works(): void
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create(['email_verified_at' => null]);

        $this
            ->actingAs($user)
            ->get(route('verification.notice'))

            ->assertOk();
    }

    /** @test */
    public function the_verification_is_not_working_if_already_verified(): void
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create(['email_verified_at' => Carbon::now()]);

        $this
            ->actingAs($user)
            ->get(route('verification.notice'))

            ->assertRedirect();
    }

    /** @test */
    public function a_link_can_be_requested_again(): void
    {
        Notification::fake();

        $user = factory(User::class)->create(['email_verified_at' => null]);

        $this
            ->actingAs($user)
            ->followingRedirects()
            ->post(route('verification.resend'))

            ->assertOk();

        Notification::assertSentTo($user, VerifyEmail::class);
    }
}

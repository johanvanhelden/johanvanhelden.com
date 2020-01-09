<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * Tests for the user's email verification functionality.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class VerificationTest extends TestCase
{
    /** @test */
    public function the_verification_page_works()
    {
        $user = factory(User::class)->create(['email_verified_at' => null]);

        $response = $this->actingAs($user)
            ->get(route('verification.notice'));

        $response->assertOk();
        $response->assertViewIs('auth.verify');
    }

    /** @test */
    public function a_link_can_be_requested_again()
    {
        Notification::fake();

        $user = factory(User::class)->create(['email_verified_at' => null]);

        $response = $this->actingAs($user)
            ->followingRedirects()
            ->post(route('verification.resend'));

        $response->assertOk();

        Notification::assertSentTo($user, VerifyEmail::class);
    }
}

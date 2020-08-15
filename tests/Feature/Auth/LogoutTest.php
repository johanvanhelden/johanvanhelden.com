<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use Tests\TestCase;

class LogoutTest extends TestCase
{
    /** @test */
    public function a_user_can_log_out(): void
    {
        $this
            ->followingRedirects()
            ->actingAs($this->user)
            ->post(route('logout'))

            ->assertOk();

        $this->assertGuest();
    }
}

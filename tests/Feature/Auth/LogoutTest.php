<?php

namespace Tests\Feature\Auth;

use Tests\Helpers\User;
use Tests\TestCase;

/**
 * Tests to ensure the logout module is functioning properly.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class LogoutTest extends TestCase
{
    /** @test */
    public function a_user_can_log_out()
    {
        $response = $this
            ->followingRedirects()
            ->actingAs(User::getUser())
            ->post(route('logout'));

        $response->assertViewIs('layouts.app');
        $this->assertGuest();
    }
}

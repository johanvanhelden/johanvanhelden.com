<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use Tests\TestCase;

class PasswordConfirmTest extends TestCase
{
    /** @test */
    public function a_user_can_view_the_page(): void
    {
        $this
            ->actingAs($this->user)
            ->get(route('password.confirm'))

            ->assertOk();
    }
}

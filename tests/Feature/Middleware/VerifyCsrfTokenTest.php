<?php

declare(strict_types=1);

namespace Tests\Feature\Middleware;

use App\Http\Middleware\VerifyCsrfToken;
use Tests\TestCase;

class VerifyCsrfTokenTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setup();

        $this->partialMock(VerifyCsrfToken::class, function ($mock): void {
            $mock
                ->shouldAllowMockingProtectedMethods(true)
                ->shouldReceive('runningUnitTests')
                ->andReturn(false);
        });
    }

    /** @test */
    public function if_the_token_is_invalid_the_user_is_logged_out_and_shown_a_message(): void
    {
        $this
            ->actingAs($this->user)
            ->post(route('subscriber.store'), [
                'name'   => $this->user->name,
                'email'  => 'edit@test.nl',
                '_token' => 'FAKE',
            ])

            ->assertRedirect(route('login'))
            ->assertSessionHas('flash_notification');

        $this->assertGuest();
    }

    /** @test */
    public function if_the_token_is_invalid_the_guest_is_redirected_to_the_login_page_and_shown_a_message(): void
    {
        $this
            ->post(route('password.email'), [
                'email'  => 'test@test.nl',
                '_token' => 'FAKE',
            ])

            ->assertRedirect(route('login'))
            ->assertSessionHas('flash_notification');
    }
}

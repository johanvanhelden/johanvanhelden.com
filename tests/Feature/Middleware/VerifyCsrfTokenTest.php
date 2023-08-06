<?php

declare(strict_types=1);

namespace Tests\Feature\Middleware;

use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
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
    public function if_the_token_is_invalid_the_guest_is_redirected_to_the_home_page_and_shown_a_message(): void
    {
        Route::post('test/url', fn () => true)
            ->middleware(['web']);

        $this
            ->post('test/url', [
                'email'  => 'test@test.nl',
                '_token' => 'FAKE',
            ])

            ->assertRedirect(route('page.home'))
            ->assertSessionHas('flash_notification');
    }
}

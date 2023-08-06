<?php

declare(strict_types=1);

namespace Tests\Feature\Middleware;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class AuthenticateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Route::get('::test-url::', fn () => true)->middleware('auth');
    }

    /** @test */
    public function if_a_json_request_the_user_will_see_a_message(): void
    {
        $this
            ->getJson('::test-url::')

            ->assertJson(['message' => 'Unauthenticated.']);
    }

    /** @test */
    public function if_not_a_json_request_the_user_will_be_redirected(): void
    {
        $this
            ->get('::test-url::')

            ->assertRedirect(route('page.home'));
    }
}

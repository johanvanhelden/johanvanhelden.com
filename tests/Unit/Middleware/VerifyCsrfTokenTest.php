<?php

declare(strict_types=1);

namespace Tests\Unit\Middleware;

use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Tests\TestCase;

class VerifyCsrfTokenTest extends TestCase
{
    protected object $middleware;

    protected function setUp(): void
    {
        parent::setup();

        $this->partialMock(VerifyCsrfToken::class, function ($mock): void {
            $mock
                ->shouldAllowMockingProtectedMethods(true)
                ->shouldReceive('runningUnitTests')
                ->andReturn(false);
        });

        $this->middleware = $this->app->make(VerifyCsrfToken::class);
    }

    /** @test */
    public function if_the_token_is_invalid_the_user_is_logged_out_and_shown_a_message(): void
    {
        $user = $this->user;

        $this->partialMock(Request::class, function ($mock): void {
            $mock->shouldAllowMockingProtectedMethods(true);
            $mock->shouldReceive('runningUnitTests')->andReturn(false);
            $mock->shouldReceive('method')->andReturn(false);
            $mock->shouldReceive('input')->andReturn('_FAKE');
            $mock->shouldReceive('session')->andReturn(optional('something'));
        });

        /** @var Request */
        $request = $this->app->make(Request::class);
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        $closure = function (): void {
            //
        };

        /** @var \Illuminate\Http\RedirectResponse */
        $response = $this->middleware->handle($request, $closure);
        $notification = $response->getSession()->get('flash_notification')->first();

        $sessionKeys = array_keys($response->getSession()->all());
        foreach ($sessionKeys as $sessionKey) {
            $this->assertFalse(Str::of($sessionKey)->startsWith('login_web_'), 'A session was found for the user.');
        }

        $this->assertEquals(__('message.session_expired'), $notification->message);
        $this->assertEquals(route('login'), $response->headers->get('location'));
    }
}

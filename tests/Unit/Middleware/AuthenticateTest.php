<?php

declare(strict_types=1);

namespace Tests\Unit\Middleware;

use App\Http\Middleware\Authenticate;
use Illuminate\Http\Request;
use Tests\TestCase;

class AuthenticateTest extends TestCase
{
    protected object $middleware;

    protected function setUp(): void
    {
        parent::setup();

        $this->partialMock(Authenticate::class, function ($mock): void {
            $mock->shouldAllowMockingProtectedMethods(true);
        });

        $this->middleware = $this->app->make(Authenticate::class);
    }

    /** @test */
    public function if_a_json_request_nothing_will_be_returned(): void
    {
        $request = Request::create('/awesome-test', 'GET');
        $request->headers->add(['Accept' => 'application/json']);

        $this->assertNull($this->middleware->redirectTo($request));
    }

    /** @test */
    public function if_not_a_json_request_the_login_url_will_be_returned(): void
    {
        $request = Request::create('/awesome-test', 'GET');

        $this->assertEquals(route('login'), $this->middleware->redirectTo($request));
    }
}

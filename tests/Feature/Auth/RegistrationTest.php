<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    /** @test */
    public function a_visitor_can_not_view_the_page(): void
    {
        $this->withoutExceptionHandling();
        $this->expectException(RouteNotFoundException::class);

        $this
            ->get(route('register'));
    }

    /** @test */
    public function a_visitor_can_not_post(): void
    {
        $this->withoutExceptionHandling();
        $this->expectException(RouteNotFoundException::class);

        $this
            ->post(route('register'));
    }
}

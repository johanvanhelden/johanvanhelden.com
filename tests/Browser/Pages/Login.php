<?php

declare(strict_types=1);

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class Login extends Page
{
    /** @var string */
    public $routeName = 'login';

    public function url(): string
    {
        return route($this->routeName);
    }

    public function assert(Browser $browser): void
    {
        $browser->assertRouteIs($this->routeName);
    }

    public function elements(): array
    {
        return [];
    }
}

<?php

declare(strict_types=1);

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class Home extends Page
{
    /** @var string */
    public $routeName = 'page.home';

    public function url(): string
    {
        return route($this->routeName);
    }

    public function assert(Browser $browser): void
    {
        $browser->assertRouteIs($this->routeName);
    }
}

<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

/**
 * Defines the login page.
 */
class Login extends Page
{
    /** @var string */
    public $routeName = 'login';

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return route($this->routeName);
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param Browser $browser
     */
    public function assert(Browser $browser)
    {
        $browser->assertRouteIs($this->routeName);
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [];
    }
}

<?php

declare(strict_types=1);

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Home;
use Tests\DuskTestCase;

class GeneralTest extends DuskTestCase
{
    /** @test */
    public function the_site_works(): void
    {
        $this->browse(function (Browser $browser): void {
            $browser
                ->visit(new Home())
                ->assertSee(config('app.name'))
                ->assertSee('Thank you for taking the time to check out my website.');
        });
    }
}

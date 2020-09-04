<?php

declare(strict_types=1);

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Login;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseTransactions;

    /** @test */
    public function fields_are_required(): void
    {
        $this->browse(function (Browser $browser): void {
            $browser
                ->visit(new Login())
                ->assertSee(config('app.name'))
                ->assertSee(__('page-auth.login.page_title'))

                ->press(__('action.login'))

                ->waitForText(__('validation.required', ['attribute' => 'email']))

                ->assertSee(__('validation.required', ['attribute' => 'email']))
                ->assertSee(__('validation.required', ['attribute' => 'password']));
        });
    }

    /** @test */
    public function is_impossible_with_invalid_credentials(): void
    {
        $this->browse(function (Browser $browser): void {
            $browser
                ->visit(new Login())
                ->type('email', 'fake-email@notreal.com')
                ->type('password', 'very-fake-indeed')

                ->press(__('action.login'))

                ->waitForText(__('auth.failed'))

                ->assertSee(__('auth.failed'));
        });
    }
}

<?php

declare(strict_types=1);

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Login;
use Tests\DuskTestCase;

class GeneralTest extends DuskTestCase
{
    use DatabaseTransactions;

    /** @test */
    public function login_fields_are_required(): void
    {
        $this->browse(function (Browser $browser): void {
            $browser
                ->visit(new Login())
                ->assertSee(config('app.name'))
                ->assertSee(__('page-auth.login.page_title'))

                ->click('@login-button')

                ->waitForText(__('validation.required', ['attribute' => 'email']))

                ->assertSee(__('validation.required', ['attribute' => 'email']))
                ->assertSee(__('validation.required', ['attribute' => 'password']));
        });
    }

    /** @test */
    public function login_is_impossible_with_invalid_credentials(): void
    {
        $this->browse(function (Browser $browser): void {
            $browser
                ->visit(new Login())
                ->type('email', 'fake-email@notreal.com')
                ->type('password', 'very-fake-indeed')

                ->click('@login-button')

                ->waitForText(__('auth.failed'))

                ->assertSee(__('auth.failed'));
        });
    }
}

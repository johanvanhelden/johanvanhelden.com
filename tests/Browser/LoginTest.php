<?php

declare(strict_types=1);

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Helpers\User;
use Tests\Browser\Pages\Login;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

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

    /** @test */
    public function can_be_done_with_valid_credentials(): void
    {
        $adminUser = User::createAdminUser();

        $this->browse(function (Browser $browser) use ($adminUser): void {
            $browser
                ->visit(new Login())
                ->type('email', $adminUser->email)
                ->type('password', User::ADMIN_USER_PASSWORD)

                ->press(__('action.login'))

                ->waitForText(__('Dashboard'))
                ->assertSee(__('Dashboard'));
        });
    }
}

<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Login;
use Tests\DuskTestCase;
use Tests\Helpers\User;

/**
 * The login tests.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function fields_are_required()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Login())
                ->assertSee(config('app.name'))
                ->assertSee(__('page-auth.login.page_title'))
                ->press(__('action.login'))
                ->assertSee(__('validation.required', ['attribute' => 'email']))
                ->assertSee(__('validation.required', ['attribute' => 'password']));
        });
    }

    /** @test */
    public function is_impossible_with_invalid_credentials()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Login())
                ->type('email', 'fake-email@notreal.com')
                ->type('password', 'very-fake-indeed')
                ->click('@login-button')

                ->assertSee(__('auth.failed'));
        });
    }

    /** @test */
    public function can_be_done_with_valid_credentials()
    {
        $adminUser = User::createAdminUser();

        $this->browse(function (Browser $browser) use ($adminUser) {
            $browser
              ->visit(new Login())
              ->type('email', $adminUser->email)
              ->type('password', User::ADMIN_USER_PASSWORD)
              ->click('@login-button')
              ->assertSee(__('Dashboard'));
        });
    }
}

<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @test */
    public function a_visitor_can_view_the_page(): void
    {
        $this
            ->get(route('login'))

            ->assertOk();
    }

    /** @test */
    public function an_admin_can_login(): void
    {
        $admin = factory(User::class)->state('admin')->create();

        $this
            ->post(route('login'), [
                'email'    => $admin->email,
                'password' => 'password',
            ])

            ->assertRedirect(url(config('nova.path')));

        $this->assertAuthenticatedAs($admin);
    }

    /** @test */
    public function a_user_can_login(): void
    {
        $user = factory(User::class)->state('user')->create();

        $this
            ->post(route('login'), [
                'email'    => $user->email,
                'password' => 'password',
            ])

            ->assertRedirect(url(config('nova.path')));

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function with_invalid_credentials_results_in_an_error(): void
    {
        $this
            ->post(route('login'), [
                'email'    => 'fake@address.com',
                'password' => 'sup3rduperfake!',
            ])

            ->assertSessionHasErrors('email');

        $this->assertTrue(session()->hasOldInput('email'), 'The session does not contain the old email address.');
        $this->assertFalse(session()->hasOldInput('password'), 'The session contains the old password.');
        $this->assertGuest();
    }
}

<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class PasswordConfirmTest extends TestCase
{
    /** @test */
    public function a_user_can_view_the_page(): void
    {
        $this
            ->actingAs($this->user)
            ->get(route('password.confirm'))

            ->assertOk();
    }

    /** @test */
    public function a_user_password_gets_confirmed(): void
    {
        $user = factory(User::class)->state('user')->create();

        $this
            ->actingAs($user)
            ->get(route('page.home'));

        $confirmedAt = Session::get('auth.password_confirmed_at');

        $this
            ->actingAs($user)
            ->post(route('password.confirm'), ['password' => 'password']);

        $this->assertNotEquals(
            $confirmedAt,
            Session::get('auth.password_confirmed_at')
        );
    }
}

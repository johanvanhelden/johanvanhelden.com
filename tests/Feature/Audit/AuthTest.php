<?php

declare(strict_types=1);

namespace Tests\Feature\Audit;

use App\Enums\Audit\Event;
use App\Models\User;

class AuthTest extends BaseTest
{
    /** @test */
    public function it_is_created_when_a_user_logged_in(): void
    {
        $user = factory(User::class)->state('user')->create();

        $this
            ->post(route('login'), [
                'email'    => $user->email,
                'password' => 'password',
            ])

            ->assertRedirect(url(config('nova.path')));

        $this->assertAuthenticatedAs($user);

        $this->assertDatabaseHas('audits', [
            'user_id'        => $user->id,
            'event'          => Event::LOGGED_IN,
            'auditable_type' => User::class,
            'auditable_id'   => $user->id,
        ]);
    }

    /** @test */
    public function it_is_created_when_a_user_logged_out(): void
    {
        $user = factory(User::class)->state('user')->create();

        $this
            ->actingAs($user)
            ->post(route('logout'))

            ->assertRedirect(route('page.home'));

        $this->assertDatabaseHas('audits', [
            'user_id'        => $user->id,
            'event'          => Event::LOGGED_OUT,
            'auditable_type' => User::class,
            'auditable_id'   => $user->id,
        ]);
    }
}

<?php

declare(strict_types=1);

namespace Tests\Feature\Activity;

use App\Enums\Activity\Event;
use App\Models\User;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /** @test */
    public function it_is_created_when_a_user_logged_in(): void
    {
        $user = User::factory()->create()->assignRole('user');

        $this
            ->post(route('login'), [
                'email'    => $user->email,
                'password' => 'password',
            ])

            ->assertRedirect(url(config('nova.path')));

        $this->assertAuthenticatedAs($user);

        $this->assertDatabaseHas('activity_log', [
            'causer_id'    => $user->id,
            'causer_type'  => User::class,
            'description'  => Event::LOGGED_IN,
            'subject_id'   => null,
            'subject_type' => null,
        ]);
    }

    /** @test */
    public function it_is_created_when_a_user_logged_out(): void
    {
        $this
            ->actingAs($this->user)
            ->post(route('logout'))

            ->assertRedirect(route('page.home'));

        $this->assertDatabaseHas('activity_log', [
            'causer_id'    => $this->user->id,
            'causer_type'  => User::class,
            'description'  => Event::LOGGED_OUT,
            'subject_id'   => null,
            'subject_type' => null,
        ]);
    }
}

<?php

declare(strict_types=1);

namespace Tests\Feature\Activity;

use App\Enums\Activity\Event;
use App\Models\User;
use Carbon\Carbon;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function it_exists_for_the_create_action(): void
    {
        $user = User::factory()->make();

        $data = array_merge($user->toArray(), [
            'password'          => 'Test123!',
            'email_verified_at' => Carbon::now()->format(config('format.datetime_nova')),
        ]);

        $response = $this
            ->actingAs($this->admin)
            ->postJson('nova-api/users', $data);

        $response->assertCreated();

        $createdUser = $response->json('resource');

        $this->assertDatabaseHas('activity_log', [
            'causer_id'    => $this->admin->id,
            'causer_type'  => User::class,
            'description'  => Event::CREATED,
            'subject_id'   => $createdUser['id'],
            'subject_type' => User::class,
        ]);
    }

    /** @test */
    public function it_exists_for_the_update_action(): void
    {
        $data = array_merge($this->user->toArray(), [
            'email'             => 'updated@email.com',
            'roles'             => 2,
            'email_verified_at' => Carbon::now()->format(config('format.datetime_nova')),
        ]);

        $this
            ->actingAs($this->admin)
            ->putJson('nova-api/users/' . $this->user->id, $data)

            ->assertOk();

        $this->assertDatabaseHas('activity_log', [
            'causer_id'    => $this->admin->id,
            'causer_type'  => User::class,
            'description'  => Event::UPDATED,
            'subject_id'   => $this->user->id,
            'subject_type' => User::class,
        ]);
    }

    /** @test */
    public function it_exists_for_the_delete_action(): void
    {
        $this
            ->actingAs($this->admin)
            ->delete('nova-api/users/', ['resources' => $this->user->id]);

        $this->assertDatabaseHas('activity_log', [
            'causer_id'    => $this->admin->id,
            'causer_type'  => User::class,
            'description'  => Event::DELETED,
            'subject_id'   => $this->user->id,
            'subject_type' => User::class,
        ]);
    }
}

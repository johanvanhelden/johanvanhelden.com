<?php

declare(strict_types=1);

namespace Tests\Feature\Audit;

use App\Enums\Audit\Event;
use App\Models\User;
use Carbon\Carbon;

class UserTest extends BaseTest
{
    /** @test */
    public function it_exists_for_the_create_action(): void
    {
        $user = factory(User::class)->make();

        $data = array_merge($user->toArray(), [
            'password'          => 'Test123!',
            'email_verified_at' => Carbon::now()->format(config('format.datetime_nova')),
        ]);

        $response = $this
            ->actingAs($this->admin)
            ->postJson('nova-api/users', $data);

        $response->assertCreated();

        $createdUser = $response->json('resource');

        $this->assertDatabaseHas('audits', [
            'user_type'      => User::class,
            'user_id'        => $this->admin->id,
            'event'          => Event::CREATED,
            'auditable_type' => User::class,
            'auditable_id'   => $createdUser['id'],
        ]);
    }

    /** @test */
    public function it_exists_for_the_update_action(): void
    {
        $user = factory(User::class)->state('user')->create();

        $data = array_merge($user->toArray(), [
            'email'             => 'updated@email.com',
            'roles'             => 2,
            'email_verified_at' => Carbon::now()->format(config('format.datetime_nova')),
        ]);

        $this
            ->actingAs($this->admin)
            ->putJson('nova-api/users/' . $user->id, $data)

            ->assertOk();

        $this->assertDatabaseHas('audits', [
            'user_type'      => User::class,
            'user_id'        => $this->admin->id,
            'event'          => Event::UPDATED,
            'auditable_type' => User::class,
            'auditable_id'   => $user->id,
        ]);
    }

    /** @test */
    public function it_exists_for_the_delete_action(): void
    {
        $user = factory(User::class)->state('user')->create();

        $this
            ->actingAs($this->admin)
            ->delete('nova-api/users/', ['resources' => $user->id]);

        $this->assertDatabaseHas('audits', [
            'user_type'      => User::class,
            'user_id'        => $this->admin->id,
            'event'          => Event::DELETED,
            'auditable_type' => User::class,
            'auditable_id'   => $user->id,
        ]);
    }
}

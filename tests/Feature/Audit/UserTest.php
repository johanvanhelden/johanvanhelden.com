<?php

namespace Tests\Feature\Audit;

use App\Models\User;
use Tests\Helpers\User as UserHelper;
use Tests\TestCase;

/**
 * Tests for user audits.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class UserTest extends TestCase
{
    /** @test */
    public function it_exists_for_the_create_action()
    {
        $admin = UserHelper::getAdmin();
        $user = factory(User::class)->make();

        $data = $user->toArray();
        $data['password'] = 'Test123!';

        $response = $this
            ->actingAs($admin)
            ->postJson('nova-api/users', $data);

        $createdUser = $response->json('resource');

        $this->assertDatabaseHas('audits', [
            'user_type'      => User::class,
            'user_id'        => $admin->id,
            'event'          => 'created',
            'auditable_type' => User::class,
            'auditable_id'   => $createdUser['id'],
        ]);
    }

    /** @test */
    public function it_exists_for_the_update_action()
    {
        $admin = UserHelper::getAdmin();
        $user = UserHelper::getUser();

        $data = $user->toArray();
        $data['email'] = 'updated@email.com';
        $data['roles'] = 2;

        $response = $this
            ->actingAs($admin)
            ->putJson('nova-api/users/' . $user->id, $data);

        $response->assertOk();

        $this->assertDatabaseHas('audits', [
            'user_type'      => User::class,
            'user_id'        => $admin->id,
            'event'          => 'updated',
            'auditable_type' => User::class,
            'auditable_id'   => $user->id,
        ]);
    }

    /** @test */
    public function it_exists_for_the_delete_action()
    {
        $admin = UserHelper::getAdmin();
        $user = UserHelper::getUser();

        $this
            ->actingAs($admin)
            ->delete('nova-api/users/', ['resources' => $user->id]);

        $this->assertDatabaseHas('audits', [
            'user_type'      => User::class,
            'user_id'        => $admin->id,
            'event'          => 'deleted',
            'auditable_type' => User::class,
            'auditable_id'   => $user->id,
        ]);
    }
}

<?php

namespace Tests\Feature\Nova\User;

use App\Notifications\SetAccountPassword;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Tests\Helpers\User;
use Tests\TestCase;

/**
 * Tests to ensure the Nova password set action is functioning properly.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class PasswordSetTest extends TestCase
{
    /** @test */
    public function an_admin_can_run_it()
    {
        $user = User::getUser();
        $actionName = Str::slug(__('nova-action.send_set_account_password'));

        $response = $this
            ->actingAs(User::getAdmin())
            ->post('/nova-api/users/action?action=' . $actionName, [
                'resources' => $user->id,
            ]);

        $response->assertOk();
    }

    /** @test */
    public function a_user_can_not_run_it()
    {
        $user = User::getUser();
        $actionName = Str::slug(__('nova-action.send_set_account_password'));

        $response = $this
            ->actingAs(User::getUser())
            ->post('/nova-api/users/action?action=' . $actionName, [
                'resources' => $user->id,
            ]);

        $response->assertForbidden();
    }

    /** @test */
    public function a_notification_is_sent_to_the_user()
    {
        Notification::fake();

        $user = User::getUser();
        $actionName = Str::slug(__('nova-action.send_set_account_password'));

        $this
            ->actingAs(User::getAdmin())
            ->post('/nova-api/users/action?action=' . $actionName, [
                'resources' => $user->id,
            ]);

        Notification::assertSentTo($user, SetAccountPassword::class);
    }
}

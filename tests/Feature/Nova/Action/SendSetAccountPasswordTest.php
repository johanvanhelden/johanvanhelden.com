<?php

declare(strict_types=1);

namespace Tests\Feature\Nova\Action;

use App\Models\NewPassword;
use App\Models\User;
use App\Notifications\SetAccountPassword;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class SendSetAccountPasswordTest extends TestCase
{
    /** @test */
    public function an_admin_can_run_it(): void
    {
        $this
            ->performAction($this->admin, $this->user)

            ->assertOk();
    }

    /** @test */
    public function a_user_can_not_run_it(): void
    {
        $this
            ->performAction($this->user, $this->user)

            ->assertForbidden();
    }

    /** @test */
    public function a_token_is_created_for_the_user(): void
    {
        $this->performAction($this->admin, $this->user);

        $token = NewPassword::latest()->first();

        $this->assertTrue($this->user->is($token->user));
    }

    /** @test */
    public function a_notification_is_sent_to_the_user(): void
    {
        Notification::fake();

        $this->performAction($this->admin, $this->user);

        Notification::assertSentTo($this->user, SetAccountPassword::class, function ($notification): bool {
            $setUrl = $this->getProperty($notification, 'actionUrl');

            $expectedUrl = route('password-set.show', [
                'email' => $this->user->email,
                'token' => NewPassword::latest()->first()->token,
            ]);

            return $setUrl === $expectedUrl;
        });
    }

    private function performAction(User $asUser, User $forUser): TestResponse
    {
        $actionName = Str::slug(__('nova-action.send_set_account_password'));

        return $this
            ->actingAs($asUser)
            ->post('/nova-api/users/action?action=' . $actionName, [
                'resources' => $forUser->id,
            ]);
    }
}

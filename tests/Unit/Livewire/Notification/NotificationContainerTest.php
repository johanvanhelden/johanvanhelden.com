<?php

declare(strict_types=1);

namespace Tests\Unit\Livewire\Notification;

use App\Http\Livewire\NotificationContainer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Livewire\Livewire;
use Tests\TestCase;

class NotificationContainerTest extends TestCase
{
    /** @test */
    public function it_can_be_populated_with_a_flash_message(): void
    {
        $message = [
            'level'   => 'error',
            'message' => 'My message',
        ];

        $notifications = new Collection([(object) $message]);

        Session::put('flash_notification', $notifications);

        Livewire::test(NotificationContainer::class)

            ->assertSet('messages.0.type', $message['level'])
            ->assertSet('messages.0.title', $message['message'])

            ->assertSeeHtml('<i class="far fa-times-circle text-red-800"></i>')
            ->assertSee('My message');
    }

    /** @test */
    public function it_can_be_notified(): void
    {
        Livewire::test(NotificationContainer::class)
            ->call('notify', 'error', 'My Test Message', 'My Description')

            ->assertSeeHtml('<i class="far fa-times-circle text-red-800"></i>')
            ->assertSee('My Test Message')
            ->assertSee('My Description');
    }

    /** @test */
    public function notifications_can_be_dismissed(): void
    {
        $message = ['uuid' => 'my-uuid', 'type' => 'info', 'title' => 'My Title', 'description' => 'Description'];

        Livewire::test(NotificationContainer::class)
            ->set('messages', new Collection([$message]))

            ->assertSeeHtml('<i class="fas fa-exclamation-circle text-blue-600"></i>')
            ->assertSee('My Title')
            ->assertSee('Description')

            ->call('dismissNotification', 'my-uuid')

            ->assertDontSeeHtml('<i class="fas fa-exclamation-circle text-blue-600"></i>')
            ->assertDontSee('My Title')
            ->assertDontSee('Description');
    }
}

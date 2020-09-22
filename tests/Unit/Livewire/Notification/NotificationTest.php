<?php

declare(strict_types=1);

namespace Tests\Unit\Livewire\Notification;

use App\Http\Livewire\Notification;
use Livewire\Livewire;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    /** @test */
    public function it_renders_the_notification(): void
    {
        Livewire::test(Notification::class, [
            'uuid'        => 'u-u-i-d',
            'type'        => 'success',
            'title'       => 'This is my title',
            'description' => 'And a fancy description',
        ])

            ->assertSeeHtml('<i class="far fa-check-circle text-green-800"></i>')
            ->assertSee('This is my title')
            ->assertSee('And a fancy description');
    }

    /** @test */
    public function it_can_be_dismissed(): void
    {
        Livewire::test(Notification::class, [
            'uuid'        => 'u-u-i-d',
            'type'        => 'success',
            'title'       => 'This is my title',
            'description' => 'And a fancy description',
        ])
            ->call('dismiss')

            ->assertEmitted('dismissNotification', 'u-u-i-d');
    }
}

<?php

declare(strict_types=1);

namespace Tests\Feature\Subscriber;

use App\Http\Livewire\SubscriptionForm;
use App\Mail\SubscriberLeft;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    /** @test */
    public function it_can_be_deleted(): void
    {
        $subscriber = Subscriber::factory()->confirmed()->create();

        Livewire::test(SubscriptionForm::class, ['subscriber' => $subscriber])
            ->call('unsubscribe');

        $this->assertDatabaseMissing('subscribers', [
            'name'  => $subscriber->name,
            'email' => $subscriber->email,
        ]);
    }

    /** @test */
    public function a_notification_is_sent(): void
    {
        Mail::fake();

        $subscriber = Subscriber::factory()->confirmed()->create();

        Livewire::test(SubscriptionForm::class, ['subscriber' => $subscriber])
            ->call('unsubscribe');

        Mail::assertSent(SubscriberLeft::class, function ($mail) {
            return $mail->hasTo('local@test.test');
        });
    }
}

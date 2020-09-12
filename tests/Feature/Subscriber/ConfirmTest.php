<?php

declare(strict_types=1);

namespace Tests\Feature\Subscriber;

use App\Mail\NewSubscriber;
use App\Mail\SubscriptionConfirmed;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ConfirmTest extends TestCase
{
    /** @test */
    public function it_can_be_confirmed(): void
    {
        $subscriber = Subscriber::factory()->confirmed(false)->create();

        $response = $this
            ->followingRedirects()
            ->get(route('subscriber.confirm', [$subscriber->uuid, $subscriber->secret]));

        $response->assertOk();

        $subscriber->refresh();

        $this->assertTrue($subscriber->is_confirmed);
    }

    /** @test */
    public function a_confirmation_is_sent(): void
    {
        Mail::fake();

        $subscriber = Subscriber::factory()->confirmed(false)->create();

        $this
            ->followingRedirects()
            ->get(route('subscriber.confirm', [$subscriber->uuid, $subscriber->secret]));

        Mail::assertSent(SubscriptionConfirmed::class, function ($mail) use ($subscriber) {
            return $mail->hasTo($subscriber->email);
        });
    }

    /** @test */
    public function a_notification_is_sent(): void
    {
        Mail::fake();

        $subscriber = Subscriber::factory()->confirmed(false)->create();

        $this
            ->followingRedirects()
            ->get(route('subscriber.confirm', [$subscriber->uuid, $subscriber->secret]));

        Mail::assertSent(NewSubscriber::class, function ($mail) {
            return $mail->hasTo('local@test.test');
        });
    }
}

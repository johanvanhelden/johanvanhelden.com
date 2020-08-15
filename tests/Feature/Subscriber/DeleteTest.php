<?php

declare(strict_types=1);

namespace Tests\Feature\Subscriber;

use App\Mail\ConfirmSubscription;
use App\Mail\SubscriberLeft;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    /** @test */
    public function it_can_be_deleted(): void
    {
        $subscriber = factory(Subscriber::class)->state('confirmed')->create();

        $response = $this
            ->followingRedirects()
            ->delete(route('subscriber.destroy', [$subscriber->uuid, $subscriber->secret]));

        $response->assertOk();

        $this->assertDatabaseMissing('subscribers', [
            'name'  => $subscriber->name,
            'email' => $subscriber->email,
        ]);
    }

    /** @test */
    public function a_notification_is_sent(): void
    {
        Mail::fake();

        $subscriber = factory(Subscriber::class)->state('confirmed')->create();

        $this->delete(route('subscriber.destroy', [$subscriber->uuid, $subscriber->secret]));

        Mail::assertSent(SubscriberLeft::class, function ($mail) {
            return $mail->hasTo('local@test.test');
        });
    }

    /** @test */
    public function if_not_confirmed_a_confirmation_mail_is_sent_instead(): void
    {
        Mail::fake();

        $subscriber = factory(Subscriber::class)->state('unconfirmed')->create();

        $this->delete(route('subscriber.destroy', [$subscriber->uuid, $subscriber->secret]));

        $this->assertDatabaseHas('subscribers', [
            'name'  => $subscriber->name,
            'email' => $subscriber->email,
        ]);

        Mail::assertSent(ConfirmSubscription::class, function ($mail) use ($subscriber) {
            return $mail->hasTo($subscriber->email);
        });
    }
}

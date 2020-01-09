<?php

namespace Tests\Feature\Subscriber;

use App\Mail\NewSubscriber;
use App\Mail\SubscriptionConfirmed;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/**
 * Test to ensure subscriptions can be created properly.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class ConfirmTest extends TestCase
{
    /** @test */
    public function it_can_be_confirmed()
    {
        $subscriber = factory(Subscriber::class)->state('unconfirmed')->create();

        $response = $this
            ->followingRedirects()
            ->get(route('subscriber.confirm', [$subscriber->uuid, $subscriber->secret]));

        $response->assertOk();

        $subscriber->refresh();

        $this->assertTrue($subscriber->is_confirmed);
    }

    /** @test */
    public function a_confirmation_is_sent()
    {
        Mail::fake();

        $subscriber = factory(Subscriber::class)->state('unconfirmed')->create();

        $this
            ->followingRedirects()
            ->get(route('subscriber.confirm', [$subscriber->uuid, $subscriber->secret]));

        Mail::assertSent(SubscriptionConfirmed::class, function ($mail) use ($subscriber) {
            return $mail->hasTo($subscriber->email);
        });
    }

    /** @test */
    public function a_notification_is_sent()
    {
        Mail::fake();

        $subscriber = factory(Subscriber::class)->state('unconfirmed')->create();

        $this
            ->followingRedirects()
            ->get(route('subscriber.confirm', [$subscriber->uuid, $subscriber->secret]));

        Mail::assertSent(NewSubscriber::class, function ($mail) {
            return $mail->hasTo('local@test.test');
        });
    }
}

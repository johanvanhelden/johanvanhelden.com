<?php

declare(strict_types=1);

namespace Tests\Feature\Subscriber;

use App\Http\Livewire\SubscriptionForm;
use App\Mail\ConfirmSubscription;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    /** @test */
    public function a_user_can_view_the_page(): void
    {
        $subscriber = Subscriber::factory()->confirmed()->create();

        $this
            ->followingRedirects()
            ->get(route('subscriber.edit', [$subscriber->uuid, $subscriber->secret]))

            ->assertOk();
    }

    /** @test */
    public function it_can_be_updated(): void
    {
        $subscriber = Subscriber::factory()->confirmed()->create([
            'name'  => 'Original',
            'email' => 'original@address.test',
        ]);

        Livewire::test(SubscriptionForm::class, ['subscriber' => $subscriber])
            ->set('subscriber.name', 'Updated')
            ->set('subscriber.email', 'updated@address.test')
            ->call('update');

        $this->assertDatabaseHas('subscribers', [
            'id'     => $subscriber->id,
            'name'   => 'Updated',
            'email'  => 'updated@address.test',
            'secret' => $subscriber->secret,
        ]);
    }

    /** @test */
    public function if_the_users_views_the_page_whilst_unconfirmed_a_mail_will_be_sent(): void
    {
        Mail::fake();

        $subscriber = Subscriber::factory()->confirmed(false)->create();

        $this
            ->followingRedirects()
            ->get(route('subscriber.edit', [$subscriber->uuid, $subscriber->secret]))

            ->assertOk();

        Mail::assertSent(ConfirmSubscription::class, function ($mail) use ($subscriber) {
            return $mail->hasTo($subscriber->email);
        });
    }

    /** @test */
    public function the_secret_and_uuid_remain_the_same(): void
    {
        $subscriber = Subscriber::factory()->confirmed(false)->create([
            'email' => 'original@address.test',
        ]);

        $uuid = $subscriber->uuid;
        $secret = $subscriber->secret;

        Livewire::test(SubscriptionForm::class, ['subscriber' => $subscriber])
            ->set('subscriber.name', 'Updated')
            ->set('subscriber.email', 'updated@address.test')
            ->call('update');

        $subscriber->refresh();

        $this->assertEquals($uuid, $subscriber->uuid, 'The UUID was altered.');
        $this->assertEquals($secret, $subscriber->secret, 'The secret was altered.');
    }

    /** @test */
    public function it_is_not_updated_if_the_email_already_exists(): void
    {
        $existingSubscriber = Subscriber::factory()->create();

        $subscriber = Subscriber::factory()->confirmed()->create([
            'email' => 'original@address.test',
        ]);

        Livewire::test(SubscriptionForm::class, ['subscriber' => $subscriber])
            ->set('subscriber.name', 'Updated')
            ->set('subscriber.email', $existingSubscriber->email)
            ->call('update');

        $this->assertDatabaseHas('subscribers', [
            'id'    => $subscriber->id,
            'email' => 'original@address.test',
        ]);
    }
}

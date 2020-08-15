<?php

declare(strict_types=1);

namespace Tests\Feature\Subscriber;

use App\Mail\ConfirmSubscription;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    /** @test */
    public function a_user_can_view_the_page(): void
    {
        $subscriber = factory(Subscriber::class)->state('confirmed')->create();

        $this
            ->followingRedirects()
            ->get(route('subscriber.edit', [$subscriber->uuid, $subscriber->secret]))

            ->assertOk();
    }

    /** @test */
    public function it_can_be_updated(): void
    {
        $subscriber = factory(Subscriber::class)->state('confirmed')->create([
            'name'  => 'Original',
            'email' => 'original@address.test',
        ]);

        $response = $this
            ->followingRedirects()
            ->put(route('subscriber.update', [$subscriber->uuid, $subscriber->secret]), [
                'name'  => 'Updated',
                'email' => 'updated@address.test',
            ]);

        $response->assertOk();

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

        $subscriber = factory(Subscriber::class)->state('unconfirmed')->create();

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
        $subscriber = factory(Subscriber::class)->state('confirmed')->create([
            'email' => 'original@address.test',
        ]);

        $uuid = $subscriber->uuid;
        $secret = $subscriber->secret;

        $this
            ->followingRedirects()
            ->put(route('subscriber.update', [$subscriber->uuid, $subscriber->secret]), [
                'email' => 'updated@address.test',
            ])

            ->assertOk();

        $subscriber->refresh();

        $this->assertEquals($uuid, $subscriber->uuid, 'The UUID was altered.');
        $this->assertEquals($secret, $subscriber->secret, 'The secret was altered.');
    }

    /** @test */
    public function it_is_not_updated_if_the_email_already_exists(): void
    {
        $existingSubscriber = factory(Subscriber::class)->create();
        $subscriber = factory(Subscriber::class)->state('confirmed')->create([
            'email' => 'original@address.test',
        ]);

        $response = $this
            ->followingRedirects()
            ->putJson(route('subscriber.update', [$subscriber->uuid, $subscriber->secret]), [
                'name'  => 'Johan',
                'email' => $existingSubscriber->email,
            ]);

        $response->assertJsonValidationErrors([
            'email' => __('validation.unique', ['attribute' => __('user.attributes.email')]),
        ]);

        $this->assertDatabaseHas('subscribers', [
            'id'    => $subscriber->id,
            'email' => 'original@address.test',
        ]);
    }

    /** @test */
    public function if_not_confirmed_a_confirmation_mail_is_sent_instead(): void
    {
        Mail::fake();

        $subscriber = factory(Subscriber::class)->state('unconfirmed')->create([
            'name'  => 'Original name',
            'email' => 'existing@address.test',
        ]);

        $this
            ->followingRedirects()
            ->put(route('subscriber.update', [$subscriber->uuid, $subscriber->secret]), [
                'name'  => 'Updated name',
                'email' => 'existing@address.test',
            ])

            ->assertOk();

        $this->assertDatabaseHas('subscribers', [
            'id'   => $subscriber->id,
            'name' => $subscriber->name,
        ]);

        Mail::assertSent(ConfirmSubscription::class, function ($mail) use ($subscriber) {
            return $mail->hasTo($subscriber->email);
        });
    }
}

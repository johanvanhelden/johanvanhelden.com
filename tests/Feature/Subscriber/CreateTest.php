<?php

declare(strict_types=1);

namespace Tests\Feature\Subscriber;

use App\Http\Livewire\SubscribeForm;
use App\Mail\ConfirmSubscription;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class CreateTest extends TestCase
{
    /** @test */
    public function it_can_be_created(): void
    {
        $subscriber = Subscriber::factory()->make();

        Livewire::test(SubscribeForm::class)
            ->set('name', $subscriber->name)
            ->set('email', $subscriber->email)
            ->call('store');

        $this->assertDatabaseHas('subscribers', [
            'name'  => $subscriber->name,
            'email' => $subscriber->email,
        ]);

        $storedSubscriber = Subscriber::where('email', $subscriber->email)->firstOrFail();

        $this->assertNotEmpty($storedSubscriber->uuid, 'The UUID has not been created');
        $this->assertNotEmpty($storedSubscriber->secret, 'The secret has not been created');
    }

    /** @test */
    public function it_is_not_created_if_the_email_already_exists(): void
    {
        Subscriber::factory()->create(['email' => 'existing@address.test']);

        Livewire::test(SubscribeForm::class)
            ->set('name', 'Johan')
            ->set('email', 'existing@address.test')
            ->call('store');

        $this->assertEquals(1, Subscriber::count());
    }

    /** @test */
    public function a_confirmation_link_is_sent(): void
    {
        Mail::fake();

        $subscriber = Subscriber::factory()->make();

        Livewire::test(SubscribeForm::class)
            ->set('name', $subscriber->name)
            ->set('email', $subscriber->email)
            ->call('store');

        Mail::assertSent(ConfirmSubscription::class, function ($mail) use ($subscriber) {
            return $mail->hasTo($subscriber->email);
        });
    }

    /** @test */
    public function if_already_exists_but_not_confirmed_a_confirmation_mail_is_sent_again(): void
    {
        Mail::fake();

        $subscriber = Subscriber::factory()->confirmed(false)->create([
            'email' => 'existing@address.test',
        ]);

        Livewire::test(SubscribeForm::class)
            ->set('name', 'Johan')
            ->set('email', 'existing@address.test')
            ->call('store');

        Mail::assertSent(ConfirmSubscription::class, function ($mail) use ($subscriber) {
            return $mail->hasTo($subscriber->email);
        });
    }
}

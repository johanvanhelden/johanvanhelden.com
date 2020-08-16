<?php

declare(strict_types=1);

namespace App\Actions\Subscriber;

use App\Mail\NewSubscriber;
use App\Mail\SubscriptionConfirmed;
use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Spatie\QueueableAction\QueueableAction;

class ConfirmSubscriber
{
    use QueueableAction;

    public function execute(Subscriber $subscriber): void
    {
        $subscriber->confirmed_at = Carbon::now();

        $subscriber->save();

        Mail::to($subscriber->email)->send(new SubscriptionConfirmed($subscriber));

        if (config('subscription.notify-self.enabled')) {
            Mail::to(config('subscription.notify-self.email'))->send(new NewSubscriber());
        }
    }
}

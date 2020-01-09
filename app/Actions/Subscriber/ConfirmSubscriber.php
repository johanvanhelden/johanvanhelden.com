<?php

namespace App\Actions\Subscriber;

use App\Mail\NewSubscriber;
use App\Mail\SubscriptionConfirmed;
use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

/**
 * The action to confirm a subscriber.
 */
class ConfirmSubscriber
{
    /**
     * Perform the action.
     *
     * @param Subscriber $subscriber
     */
    public function execute(Subscriber $subscriber)
    {
        $subscriber->confirmed_at = Carbon::now();

        $subscriber->save();

        Mail::to($subscriber->email)->send(new SubscriptionConfirmed($subscriber));

        if (config('subscription.notify-self.enabled')) {
            Mail::to(config('subscription.notify-self.email'))->send(new NewSubscriber());
        }
    }
}

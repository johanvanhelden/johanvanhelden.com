<?php

namespace App\Actions\Subscriber;

use App\Mail\SubscriberLeft;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

/**
 * The action to delete a subscriber.
 */
class DeleteSubscriber
{
    /**
     * Perform the action.
     *
     * @param Subscriber $subscriber
     */
    public function execute(Subscriber $subscriber)
    {
        $subscriber->delete();

        if (config('subscription.notify-self.enabled')) {
            Mail::to(config('subscription.notify-self.email'))->send(new SubscriberLeft());
        }
    }
}

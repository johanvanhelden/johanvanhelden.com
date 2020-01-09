<?php

namespace App\Actions\Subscriber;

use App\Mail\ConfirmSubscription;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

/**
 * The action to ask a subscriber for confirmation.
 */
class AskForConfirmation
{
    /**
     * Perform the action.
     *
     * @param Subscriber $subscriber
     */
    public function execute(Subscriber $subscriber)
    {
        Mail::to($subscriber->email)->send(new ConfirmSubscription($subscriber));
    }
}

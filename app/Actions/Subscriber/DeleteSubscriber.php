<?php

declare(strict_types=1);

namespace App\Actions\Subscriber;

use App\Mail\SubscriberLeft;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;
use Spatie\QueueableAction\QueueableAction;

class DeleteSubscriber
{
    use QueueableAction;

    public function execute(Subscriber $subscriber): void
    {
        $subscriber->delete();

        if (config('subscription.notify-self.enabled')) {
            Mail::to(config('subscription.notify-self.email'))->send(new SubscriberLeft());
        }
    }
}

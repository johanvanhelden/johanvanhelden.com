<?php

declare(strict_types=1);

namespace App\Actions\Subscriber;

use App\Mail\ConfirmSubscription;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;
use Spatie\QueueableAction\QueueableAction;

class AskForConfirmation
{
    use QueueableAction;

    public function execute(Subscriber $subscriber): void
    {
        Mail::to($subscriber->email)->send(new ConfirmSubscription($subscriber));
    }
}

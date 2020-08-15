<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Subscriber;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmSubscription extends Mailable
{
    use SerializesModels;

    public Subscriber $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    /** @return $this */
    public function build()
    {
        return $this
            ->subject(__('mail.confirm_subscription.subject'))
            ->markdown('mailable.confirm-subscription');
    }
}

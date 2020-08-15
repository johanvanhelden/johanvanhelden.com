<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Subscriber;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionConfirmed extends Mailable
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
            ->subject(__('mail.subscription_confirmed.subject'))
            ->markdown('mailable.subscription-confirmed');
    }
}

<?php

namespace App\Mail;

use App\Models\Subscriber;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Defines the "subscription confirmed" mail.
 */
class SubscriptionConfirmed extends Mailable
{
    use SerializesModels;

    /** @var Subscriber */
    public $subscriber;

    /**
     * Create a new message instance.
     *
     * @param Subscriber $subscriber
     */
    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(__('mail.subscription_confirmed.subject'))
            ->markdown('mailable.subscription-confirmed');
    }
}

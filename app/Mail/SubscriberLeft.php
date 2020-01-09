<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Defines the "subscriber left" mail.
 */
class SubscriberLeft extends Mailable
{
    use SerializesModels;

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(__('mail.subscriber_left.subject'))
            ->markdown('mailable.subscriber-left');
    }
}

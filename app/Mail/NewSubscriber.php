<?php

namespace App\Mail;

use App\Models\Subscriber;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Defines the "new subscriber" mail.
 */
class NewSubscriber extends Mailable
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
            ->subject(__('mail.new_subscriber.subject'))
            ->markdown('mailable.new-subscriber');
    }
}

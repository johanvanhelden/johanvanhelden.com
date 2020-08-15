<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriberLeft extends Mailable
{
    use SerializesModels;

    /** @return $this */
    public function build()
    {
        return $this
            ->subject(__('mail.subscriber_left.subject'))
            ->markdown('mailable.subscriber-left');
    }
}

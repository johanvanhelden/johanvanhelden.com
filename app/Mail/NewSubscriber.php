<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewSubscriber extends Mailable
{
    use SerializesModels;

    /** @return $this */
    public function build()
    {
        return $this
            ->subject(__('mail.new_subscriber.subject'))
            ->markdown('mailable.new-subscriber');
    }
}

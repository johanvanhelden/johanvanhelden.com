<?php

declare(strict_types=1);

namespace App\Actions\Subscriber;

use App\Models\Subscriber;
use Spatie\QueueableAction\QueueableAction;

class UpdateSubscriber
{
    use QueueableAction;

    public function execute(Subscriber $subscriber, array $data): void
    {
        $subscriber->update($data);
    }
}

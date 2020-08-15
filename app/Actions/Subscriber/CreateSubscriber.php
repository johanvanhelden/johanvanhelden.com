<?php

declare(strict_types=1);

namespace App\Actions\Subscriber;

use App\Models\Subscriber;
use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

class CreateSubscriber
{
    use QueueableAction;

    private AskForConfirmation $confirmationAction;

    public function __construct(AskForConfirmation $action)
    {
        $this->confirmationAction = $action;
    }

    public function execute(array $data): void
    {
        $subscriber = new Subscriber($data);

        $subscriber->uuid = Str::uuid()->toString();
        $subscriber->secret = hash_hmac('sha256', Str::random(40), config('app.key'));

        $subscriber->save();

        $this->confirmationAction->execute($subscriber);
    }
}

<?php

namespace App\Actions\Subscriber;

use App\Models\Subscriber;
use Illuminate\Support\Str;

/**
 * The action to create a subscriber.
 */
class CreateSubscriber
{
    /** @var AskForConfirmation */
    private $confirmationAction;

    /**
     * Constructs the action.
     *
     * @param AskForConfirmation $action
     */
    public function __construct(AskForConfirmation $action)
    {
        $this->confirmationAction = $action;
    }

    /**
     * Perform the action.
     *
     * @param array $data
     */
    public function execute(array $data)
    {
        $subscriber = new Subscriber($data);

        $subscriber->uuid = Str::uuid()->toString();
        $subscriber->secret = hash_hmac('sha256', Str::random(40), config('app.key'));

        $subscriber->save();

        $this->confirmationAction->execute($subscriber);
    }
}

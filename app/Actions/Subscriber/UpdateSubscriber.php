<?php

namespace App\Actions\Subscriber;

use App\Models\Subscriber;

/**
 * The action to update a subscriber.
 */
class UpdateSubscriber
{
    /**
     * Perform the action.
     *
     * @param array $data
     */
    public function execute(Subscriber $subscriber, array $data)
    {
        $subscriber->update($data);
    }
}

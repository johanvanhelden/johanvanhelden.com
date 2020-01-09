<?php

namespace App\Policies;

/**
 * The subscriber policy.
 */
class SubscriberPolicy extends BasePolicy
{
    /**
     * Set the permission that is needed.
     */
    public function __construct()
    {
        $this->permission = 'manage-subscribers';
    }
}

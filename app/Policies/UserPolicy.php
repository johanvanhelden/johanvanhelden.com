<?php

namespace App\Policies;

/**
 * The user policy.
 */
class UserPolicy extends BasePolicy
{
    /**
     * Set the permission that is needed.
     */
    public function __construct()
    {
        $this->permission = 'manage-users';
    }
}

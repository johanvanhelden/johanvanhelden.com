<?php

namespace App\Policies;

/**
 * The tool policy.
 */
class ToolPolicy extends BasePolicy
{
    /**
     * Set the permission that is needed.
     */
    public function __construct()
    {
        $this->permission = 'manage-tools';
    }
}

<?php

namespace App\Policies;

use App\Models\User;
use Carbon\Carbon;

/**
 * The project policy.
 */
class ProjectPolicy extends BasePolicy
{
    /**
     * Set the permission that is needed.
     */
    public function __construct()
    {
        $this->permission = 'manage-projects';
    }

    /**
     * Determines if the user can view the entity.
     *
     * @param User  $user
     * @param mixed $entity
     *
     * @return bool
     */
    public function view(?User $user, $entity)
    {
        if (!$user) {
            $isPublished = !empty($entity->publish_at);
            $isVisible = $entity->publish_at <= Carbon::now();

            if ($isPublished && $isVisible) {
                return true;
            }

            return false;
        }

        return $user->can($this->permission);
    }
}

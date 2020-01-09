<?php

namespace App\Policies;

use App\Models\User;

/**
 * The permission policy.
 */
class PermissionPolicy extends BasePolicy
{
    /**
     * Set the permission that is needed.
     */
    public function __construct()
    {
        $this->permission = 'manage-permissions';
    }

    /**
     * Determines if the user can create a new entity.
     *
     * @param User $user
     *
     * @return bool
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determines if the user can update the entity.
     *
     * @param User  $user
     * @param mixed $entity
     *
     * @return bool
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function update(User $user, $entity)
    {
        return false;
    }

    /**
     * Determines if the user can delete the entity.
     *
     * @param User  $user
     * @param mixed $entity
     *
     * @return bool
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function delete(User $user, $entity)
    {
        return false;
    }

    /**
     * Determines if the user can restore the entity.
     *
     * @param User  $user
     * @param mixed $entity
     *
     * @return bool
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function restore(User $user, $entity)
    {
        return false;
    }

    /**
     * Determines if the user can force-delete the entity.
     *
     * @param User  $user
     * @param mixed $entity
     *
     * @return bool
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function forceDelete(User $user, $entity)
    {
        return false;
    }
}

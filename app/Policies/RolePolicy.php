<?php

namespace App\Policies;

use App\Models\User;

/**
 * The role policy.
 */
class RolePolicy extends BasePolicy
{
    /**
     * Set the permission that is needed.
     */
    public function __construct()
    {
        $this->permission = 'manage-roles';
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
        $can = $user->can($this->permission);
        $isDefault = in_array($entity->name, array_keys(config('defaults.roles')));

        return $can && !$isDefault;
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
        $can = $user->can($this->permission);
        $isDefault = in_array($entity->name, array_keys(config('defaults.roles')));

        return $can && !$isDefault;
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
        $can = $user->can($this->permission);
        $isDefault = in_array($entity->name, array_keys(config('defaults.roles')));

        return $can && !$isDefault;
    }
}

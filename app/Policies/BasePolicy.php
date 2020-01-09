<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * The base policy.
 */
class BasePolicy
{
    use HandlesAuthorization;

    /** @var string */
    protected $permission = '--never-allowed--';

    /**
     * Determines if the user can view any entity.
     *
     * @param User $user
     *
     * @return bool
     */
    public function viewAny(User $user)
    {
        return $user->can($this->permission);
    }

    /**
     * Determines if the user can view the entity.
     *
     * @param User  $user
     * @param mixed $entity
     *
     * @return bool
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function view(User $user, $entity)
    {
        return $user->can($this->permission);
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
        return $user->can($this->permission);
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
        return $user->can($this->permission);
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
        return $user->can($this->permission);
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
        return $user->can($this->permission);
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
        return $user->can($this->permission);
    }
}

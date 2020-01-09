<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * The audit policy.
 */
class AuditPolicy
{
    use HandlesAuthorization;

    /** @var string */
    protected $permission = 'manage-audits';

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
}

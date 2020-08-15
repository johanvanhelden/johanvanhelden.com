<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    protected string $permission = 'manage-users';

    public function viewAny(User $user): bool
    {
        return $user->can($this->permission);
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function view(User $currentUser, User $user): bool
    {
        return $currentUser->can($this->permission);
    }

    public function create(User $currentUser): bool
    {
        return $currentUser->can($this->permission);
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function update(User $currentUser, User $user): bool
    {
        return $currentUser->can($this->permission);
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function delete(User $currentUser, User $user): bool
    {
        return $currentUser->can($this->permission);
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function restore(User $currentUser, User $user): bool
    {
        return $currentUser->can($this->permission);
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function forceDelete(User $currentUser, User $user): bool
    {
        return $currentUser->can($this->permission);
    }
}

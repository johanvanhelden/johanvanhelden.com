<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Permission;

class PermissionPolicy
{
    use HandlesAuthorization;

    protected string $permission = 'manage-permissions';

    public function viewAny(User $user): bool
    {
        return $user->can($this->permission);
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function view(User $user, Permission $permission): bool
    {
        return $user->can($this->permission);
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function create(User $user): bool
    {
        return false;
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function update(User $user, Permission $permission): bool
    {
        return false;
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function delete(User $user, Permission $permission): bool
    {
        return false;
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function restore(User $user, Permission $permission): bool
    {
        return false;
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function forceDelete(User $user, Permission $permission): bool
    {
        return false;
    }
}

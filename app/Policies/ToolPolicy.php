<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Tool;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ToolPolicy
{
    use HandlesAuthorization;

    protected string $permission = 'manage-tools';

    public function viewAny(User $user): bool
    {
        return $user->can($this->permission);
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function view(User $user, Tool $tool): bool
    {
        return $user->can($this->permission);
    }

    public function create(User $user): bool
    {
        return $user->can($this->permission);
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function update(User $user, Tool $tool): bool
    {
        return $user->can($this->permission);
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function delete(User $user, Tool $tool): bool
    {
        return $user->can($this->permission);
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function restore(User $user, Tool $tool): bool
    {
        return $user->can($this->permission);
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function forceDelete(User $user, Tool $tool): bool
    {
        return $user->can($this->permission);
    }
}

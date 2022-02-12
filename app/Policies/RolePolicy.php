<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    use HandlesAuthorization;

    protected string $permission = 'manage-roles';

    public function viewAny(User $user): bool
    {
        return $user->can($this->permission);
    }

    public function view(User $user, Role $role): bool
    {
        return $user->can($this->permission);
    }

    public function create(User $user): bool
    {
        return $user->can($this->permission);
    }

    public function update(User $user, Role $role): bool
    {
        $can = $user->can($this->permission);
        $isDefault = in_array($role->name, array_keys(config('bootstrap.roles')));

        return $can && !$isDefault;
    }

    public function delete(User $user, Role $role): bool
    {
        $can = $user->can($this->permission);
        $isDefault = in_array($role->name, array_keys(config('bootstrap.roles')));

        return $can && !$isDefault;
    }

    public function restore(User $user, Role $role): bool
    {
        $can = $user->can($this->permission);
        $isDefault = in_array($role->name, array_keys(config('bootstrap.roles')));

        return $can && !$isDefault;
    }

    public function forceDelete(User $user, Role $role): bool
    {
        $can = $user->can($this->permission);
        $isDefault = in_array($role->name, array_keys(config('bootstrap.roles')));

        return $can && !$isDefault;
    }
}

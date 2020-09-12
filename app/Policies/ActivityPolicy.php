<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ActivityPolicy
{
    use HandlesAuthorization;

    protected string $permission = 'manage-activities';

    public function viewAny(User $user): bool
    {
        return $user->can($this->permission);
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function view(User $user, Activity $activityt): bool
    {
        return $user->can($this->permission);
    }
}

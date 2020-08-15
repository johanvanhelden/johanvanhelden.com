<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    protected string $permission = 'manage-projects';

    public function viewAny(User $user): bool
    {
        return $user->can($this->permission);
    }

    public function view(?User $user, Project $project): bool
    {
        if (!$user) {
            $isPublished = !empty($project->publish_at);
            $isVisible = $project->publish_at <= Carbon::now();

            if ($isPublished && $isVisible) {
                return true;
            }

            return false;
        }

        return $user->can($this->permission);
    }

    public function create(User $user): bool
    {
        return $user->can($this->permission);
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function update(User $user, Project $project): bool
    {
        return $user->can($this->permission);
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function delete(User $user, Project $project): bool
    {
        return $user->can($this->permission);
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function restore(User $user, Project $project): bool
    {
        return $user->can($this->permission);
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function forceDelete(User $user, Project $project): bool
    {
        return $user->can($this->permission);
    }
}

<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Audit;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AuditPolicy
{
    use HandlesAuthorization;

    protected string $permission = 'manage-audits';

    public function viewAny(User $user): bool
    {
        return $user->can($this->permission);
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function view(User $user, Audit $audit): bool
    {
        return $user->can($this->permission);
    }
}

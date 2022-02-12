<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Laravel\Nova\Actions\ActionEvent;

class ActionEventPolicy
{
    use HandlesAuthorization;

    protected string $permission = 'manage-action-events';

    public function viewAny(User $user): bool
    {
        return $user->can($this->permission);
    }

    public function view(User $user, ActionEvent $actionEvent): bool
    {
        return $user->can($this->permission);
    }
}

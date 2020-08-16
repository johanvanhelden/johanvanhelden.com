<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Models\User;
use Spatie\QueueableAction\QueueableAction;

class AssignRole
{
    use QueueableAction;

    public function execute(User $user, string $roleName): void
    {
        $user->assignRole($roleName);
    }
}

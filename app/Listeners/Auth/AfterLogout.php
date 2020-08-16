<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use App\Models\Audit;
use Illuminate\Auth\Events\Logout;

class AfterLogout
{
    public function handle(Logout $logout): void
    {
        /** @var \App\Models\User */
        $currentUser = $logout->user;
        if (empty($currentUser)) {
            return;
        }

        Audit::createForLogout($currentUser);
    }
}

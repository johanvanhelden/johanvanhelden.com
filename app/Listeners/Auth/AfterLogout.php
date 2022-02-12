<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use App\Enums\Activity\Event;
use Illuminate\Auth\Events\Logout;

class AfterLogout
{
    public function handle(Logout $logout): void
    {
        /** @var \App\Models\User|null */
        $currentUser = $logout->user;
        if (empty($currentUser)) {
            return;
        }

        activity()->causedBy($currentUser)->log(Event::LOGGED_OUT);
    }
}

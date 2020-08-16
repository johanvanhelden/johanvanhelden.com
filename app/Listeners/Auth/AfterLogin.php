<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use App\Models\Audit;
use Illuminate\Auth\Events\Login;

class AfterLogin
{
    public function handle(Login $login): void
    {
        /** @var \App\Models\User */
        $currentUser = $login->user;
        if (empty($currentUser)) {
            return;
        }

        Audit::createForLogin($currentUser);
    }
}

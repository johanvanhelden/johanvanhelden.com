<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Models\NewPassword;
use App\Models\User;
use App\Notifications\SetAccountPassword;
use Spatie\QueueableAction\QueueableAction;

class SendSetAccountPassword
{
    use QueueableAction;

    public function execute(User $user): void
    {
        $actionUrl = route('password-set.show', [
            'email' => urlencode($user->email),
            'token' => NewPassword::createToken($user),
        ]);

        $user->notify(new SetAccountPassword($actionUrl));
    }
}

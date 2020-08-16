<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\QueueableAction\QueueableAction;

class CreateUser
{
    use QueueableAction;

    public function execute(array $data): void
    {
        $user = new User($data);
        $user->password = Hash::make($data['password']);

        if (isset($data['email_verified_at'])) {
            $user->email_verified_at = $data['email_verified_at'];
        }

        $user->save();
    }
}

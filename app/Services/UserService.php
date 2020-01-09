<?php

namespace App\Services;

use App\Models\NewPassword;
use App\Models\User;
use App\Notifications\SetAccountPassword;
use Illuminate\Support\Facades\Hash;

/**
 * Manage user logic.
 */
class UserService
{
    /**
     * Creates a new user.
     *
     * @param array $data
     *
     * @return User
     */
    public function create(array $data)
    {
        $user = new User($data);
        $user['password'] = Hash::make($data['password']);

        $user->save();

        $user->assignRole('user');

        return $user;
    }

    /**
     * Updates a user.
     *
     * @param User  $user
     * @param array $data
     *
     * @return User
     */
    public function update(User $user, array $data)
    {
        if (isset($data['new_password']) && !empty($data['new_password'])) {
            $user->password = Hash::make($data['new_password']);
        }

        $user->update($data);

        return $user;
    }

    /**
     * Send the set account password notification.
     *
     * @param User $user
     */
    public function sendSetAccountPassword(User $user)
    {
        $token = NewPassword::createToken($user);

        $actionUrl = route('password-set.show', $token);
        $actionUrl .= '?email=' . urlencode($user->email);

        $user->notify(new SetAccountPassword($actionUrl));
    }
}

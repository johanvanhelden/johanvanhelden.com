<?php

declare(strict_types=1);

namespace Tests\Browser\Helpers;

use App\Models\User as UserModel;
use Illuminate\Support\Facades\Hash;

class User
{
    /** @var string */
    const ADMIN_USER_EMAIL = 'dusk+admin@johanvanhelden.com';

    /** @var string */
    const ADMIN_USER_PASSWORD = 'duskp4$$w0rd';

    public static function createAdminUser(): UserModel
    {
        $currentAdmin = UserModel::whereEmail(self::ADMIN_USER_EMAIL)->first();
        if (!empty($currentAdmin)) {
            return $currentAdmin;
        }

        $user = factory(UserModel::class)->create([
            'name'     => 'Dusk Admin',
            'email'    => self::ADMIN_USER_EMAIL,
            'password' => Hash::make(self::ADMIN_USER_PASSWORD),
        ]);

        $user->assignRole('admin');

        return $user;
    }
}

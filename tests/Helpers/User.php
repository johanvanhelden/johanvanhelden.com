<?php

namespace Tests\Helpers;

use App\Models\User as UserModel;
use Illuminate\Support\Facades\Hash;

/**
 * User helpers.
 */
class User
{
    /** @var string */
    const ADMIN_USER_EMAIL = 'dusk+admin@johanvanhelden.com';

    /** @var string */
    const ADMIN_USER_PASSWORD = 'duskp4$$w0rd';

    /**
     * Creates a new admin user.
     *
     * @return UserModel
     */
    public static function createAdminUser()
    {
        $currentAdmin = UserModel::where('email', self::ADMIN_USER_EMAIL)->first();
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

    /**
     * Get an admin user.
     *
     * @param array $attributes
     *
     * @return UserModel
     */
    public static function getAdmin(array $attributes = [])
    {
        return factory(UserModel::class)->state('admin')->create($attributes);
    }

    /**
     * Get a "user" user.
     *
     * @param array $attributes
     *
     * @return UserModel
     */
    public static function getUser(array $attributes = [])
    {
        return factory(UserModel::class)->state('user')->create($attributes);
    }
}

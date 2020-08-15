<?php

declare(strict_types=1);

namespace Tests\Helpers;

use App\Models\User as UserModel;

class User
{
    public static function getDefaultAdmin(): UserModel
    {
        return UserModel::whereEmail('johan@johanvanhelden.com')->first();
    }

    public static function getDefaultUser(): UserModel
    {
        return UserModel::whereEmail('user@johanvanhelden.com')->first();
    }
}

<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Auth as VendorAuth;

class Auth extends VendorAuth
{
    public static function user(): ?User
    {
        return parent::user();
    }
}

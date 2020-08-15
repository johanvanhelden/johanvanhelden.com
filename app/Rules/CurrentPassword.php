<?php

declare(strict_types=1);

namespace App\Rules;

use App\Helpers\Auth;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class CurrentPassword implements Rule
{
    /**
     * @param string $attribute
     * @param mixed  $value
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function passes($attribute, $value): bool
    {
        if (empty($value)) {
            return true;
        }

        if (!Auth::check()) {
            return false;
        }

        return Hash::check($value, Auth::user()->password);
    }

    public function message(): string
    {
        return __('validation.current_password');
    }
}

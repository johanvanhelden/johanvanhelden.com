<?php

declare(strict_types=1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StrongPassword implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * At least 8 characters, a lowercase, uppercase, digit and special character.
     *
     * @param string $attribute
     */
    public function passes($attribute, mixed $value): bool
    {
        if (strlen($value) < 8) {
            return false;
        }

        if (!preg_match('/[A-Z]/', $value)) {
            return false;
        }

        if (!preg_match('/[a-z]/', $value)) {
            return false;
        }

        if (!preg_match('/[0-9]/', $value)) {
            return false;
        }

        $quoted = sprintf('/[%s]/', preg_quote('[!@#$%^&*_-]'));
        if (!preg_match($quoted, $value)) {
            return false;
        }

        return true;
    }

    public function message(): string
    {
        return __('validation.strong_password');
    }
}

<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Enforces a strong password.
 *
 * At least 8 characters, a lowercase, uppercase, digit and special character.
 */
class StrongPassword implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function passes($attribute, $value)
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

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.strong_password');
    }
}

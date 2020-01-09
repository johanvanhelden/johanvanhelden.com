<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Ensures the given string fits in the database.
 */
class DbString implements Rule
{
    /** @var int */
    private $length;

    /**
     * Create a new rule instance.
     */
    public function __construct()
    {
        $this->length = config('validation.db_string.length');
    }

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
        if (empty($value)) {
            return true;
        }

        return is_string($value) && (strlen($value) <= $this->length);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.db_string', ['length' => $this->length]);
    }
}

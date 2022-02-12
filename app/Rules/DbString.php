<?php

declare(strict_types=1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DbString implements Rule
{
    private int $length;

    public function __construct()
    {
        $this->length = config('validation.db_string.length');
    }

    /** @param string $attribute */
    public function passes($attribute, mixed $value): bool
    {
        if (empty($value)) {
            return true;
        }

        return is_string($value) && (strlen($value) <= $this->length);
    }

    public function message(): string
    {
        return __('validation.db_string', ['length' => $this->length]);
    }
}

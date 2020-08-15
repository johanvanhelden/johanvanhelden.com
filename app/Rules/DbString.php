<?php

declare(strict_types=1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DbString implements Rule
{
    /** @var int */
    private $length;

    public function __construct()
    {
        $this->length = config('validation.db_string.length');
    }

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

        return is_string($value) && (strlen($value) <= $this->length);
    }

    public function message(): string
    {
        return __('validation.db_string', ['length' => $this->length]);
    }
}

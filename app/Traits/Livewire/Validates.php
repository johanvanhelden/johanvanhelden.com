<?php

declare(strict_types=1);

namespace App\Traits\Livewire;

trait Validates
{
    public function attributesForModel(string $name): array
    {
        $attributes = [];

        foreach (__($name . '.attributes') as $key => $value) {
            $attributes[$name . '.' . $key] = strtolower($value);
        }

        return $attributes;
    }
}

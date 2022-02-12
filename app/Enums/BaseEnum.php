<?php

declare(strict_types=1);

namespace App\Enums;

use ReflectionClass;

class BaseEnum
{
    protected static string $translationKey;

    public static function toArray(): array
    {
        $class = new ReflectionClass(static::class);

        return $class->getConstants();
    }

    public static function asSelect(): array
    {
        $options = [];

        foreach (self::toArray() as $option) {
            $options[$option] = __(static::$translationKey . $option);
        }

        return $options;
    }

    public static function display(string $option): string
    {
        return __(static::$translationKey . $option);
    }
}

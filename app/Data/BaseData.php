<?php

declare(strict_types=1);

namespace App\Data;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

abstract class BaseData
{
    protected static string $filename;

    abstract public static function mapData(array $item): array;

    public static function all(): Collection
    {
        $json = File::get(resource_path('data/' . static::$filename));

        $items = (new Collection(json_decode($json, true)))->map(function ($item) {
            return static::mapData($item);
        });

        return $items;
    }

    public static function public(): Collection
    {
        return static::all()->where('is_public', true);
    }

    public static function bySlug(string $slug): array
    {
        $items = static::all();

        return $items->where('slug', $slug)->firstOrFail();
    }
}

<?php

declare(strict_types=1);

namespace App\Data;

use Carbon\Carbon;
use Illuminate\Support\Facades\Vite;

class Tool extends BaseData
{
    protected static string $filename = 'tools.json';

    public static function mapData(array $tool): array
    {
        $tool['publish_at'] = Carbon::parse($tool['publish_at']);
        $tool['created_at'] = Carbon::parse($tool['created_at']);
        $tool['updated_at'] = Carbon::parse($tool['updated_at']);

        $tool['is_public'] = self::isPublic($tool);
        $tool['image_url'] = self::imageUrl($tool);

        return $tool;
    }

    private static function imageUrl(array $tool): string
    {
        if (!is_string($tool['image'])) {
            return '';
        }

        return Vite::asset('resources/img/tools/' . $tool['image']);
    }

    public static function isPublic(array $tool): bool
    {
        $isPublished = !empty($tool['publish_at']);
        $isVisible = $tool['publish_at'] <= Carbon::now();

        if ($isPublished && $isVisible) {
            return true;
        }

        return false;
    }
}

<?php

declare(strict_types=1);

namespace App\Data;

use Carbon\Carbon;
use League\CommonMark\CommonMarkConverter;

class Project extends BaseData
{
    protected static string $filename = 'projects.json';

    public static function mapData(array $project): array
    {
        $project['publish_at'] = $project['publish_at'] ? Carbon::parse($project['publish_at']) : null;
        $project['created_at'] = $project['created_at'] ? Carbon::parse($project['created_at']) : null;
        $project['updated_at'] = $project['updated_at'] ? Carbon::parse($project['updated_at']) : null;

        $project['is_public'] = self::isPublic($project);

        $project['is_updated'] = self::isUpdated($project);
        $project['is_recently_updated'] = self::isRecentlyUpdated($project);

        $project['publish_at_display'] = self::publishAtDisplay($project);
        $project['updated_at_display'] = self::updatedAtDisplay($project);

        $project['content_display'] = self::contentDisplay($project);

        return $project;
    }

    private static function isUpdated(array $project): bool
    {
        if (!$project['publish_at']) {
            return false;
        }

        $twentyFourHoursAfterPublishing = $project['publish_at']->copy()->addHours(24);

        $isAtLeast24HoursAfter = $project['updated_at']->gte($twentyFourHoursAfterPublishing);

        if (!$isAtLeast24HoursAfter) {
            return false;
        }

        return true;
    }

    private static function isRecentlyUpdated(array $project): bool
    {
        if (!$project['is_updated']) {
            return false;
        }

        $daysSinceUpdate = Carbon::now()->diffInDays($project['updated_at']);

        if ($daysSinceUpdate <= 7) {
            return true;
        }

        return false;
    }

    private static function publishAtDisplay(array $project): ?string
    {
        if (empty($project['publish_at'])) {
            return null;
        }

        return $project['publish_at']->format(config('format.date'));
    }

    private static function updatedAtDisplay(array $project): ?string
    {
        if (empty($project['updated_at'])) {
            return null;
        }

        return $project['updated_at']->format(config('format.date'));
    }

    private static function contentDisplay(array $project): string
    {
        if (empty($project['content'])) {
            return '';
        }

        $converter = new CommonMarkConverter([
            'html_input'         => 'strip',
            'allow_unsafe_links' => false,
        ]);

        return $converter->convert($project['content'])->__toString();
    }

    public static function isPublic(array $project): bool
    {
        $isPublished = !empty($project['publish_at']);
        $isVisible = $project['publish_at'] <= Carbon::now();

        if ($isPublished && $isVisible) {
            return true;
        }

        return false;
    }
}

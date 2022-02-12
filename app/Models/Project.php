<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Publishable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use League\CommonMark\CommonMarkConverter;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Project extends Model
{
    use HasFactory, Publishable, LogsActivity;

    public static bool $logFillable = true;

    /** @var array<int, string> */
    protected $fillable = [
        'name',
        'slug',
        'excerpt',
        'content',
        'url',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept([
                'updated_at',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /** @SuppressWarnings(PHPMD.BooleanGetMethodName) */
    public function getIsUpdatedAttribute(): bool
    {
        if (!$this->publish_at) {
            return false;
        }

        if ($this->updated_at->endOfDay() <= $this->publish_at->endOfDay()) {
            return false;
        }

        return true;
    }

    /** @SuppressWarnings(PHPMD.BooleanGetMethodName) */
    public function getIsRecentlyUpdatedAttribute(): bool
    {
        if (!$this->is_updated) {
            return false;
        }

        $daysSinceUpdate = Carbon::now()->diffInDays($this->updated_at);

        if ($daysSinceUpdate <= 7) {
            return true;
        }

        return false;
    }

    public function getPublishAtDisplayAttribute(): string
    {
        return $this->publish_at->format(config('format.date'));
    }

    public function getUpdatedAtDisplayAttribute(): string
    {
        return $this->updated_at->format(config('format.date'));
    }

    public function getContentDisplayAttribute(): string
    {
        if (empty($this->content)) {
            return '';
        }

        $converter = new CommonMarkConverter([
            'html_input'         => 'strip',
            'allow_unsafe_links' => false,
        ]);

        return $converter->convert($this->content)->__toString();
    }
}

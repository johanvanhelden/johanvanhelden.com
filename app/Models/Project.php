<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Publishable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Project extends Model implements Auditable
{
    use AuditTrait, Publishable;

    /** @var array */
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
}

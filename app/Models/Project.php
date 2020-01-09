<?php

namespace App\Models;

use App\Traits\Publishable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditTrait;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Defines a project.
 */
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

    /**
     * Bind the route to the slug.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Determines if a project has been updated after publishing.
     *
     * @return bool
     *
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getIsUpdatedAttribute()
    {
        if (!$this->publish_at) {
            return false;
        }

        if ($this->updated_at->endOfDay() <= $this->publish_at->endOfDay()) {
            return false;
        }

        return true;
    }

    /**
     * Determines if a project has been recently updated.
     *
     * @return bool
     *
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getIsRecentlyUpdatedAttribute()
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

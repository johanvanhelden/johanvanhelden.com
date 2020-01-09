<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * A trait for models that are publishable.
 */
trait Publishable
{
    /**
     * This method is called upon instantiation of the Eloquent Model.
     * It adds the "publish_at" field to the "$fillable" and "$casts" array of the model.
     */
    public function initializePublishable()
    {
        $this->fillable[] = 'publish_at';

        $this->casts['publish_at'] = 'datetime';
    }

    /**
     * Filter for all published entities.
     *
     * @return Builder
     */
    public function scopePublished(Builder $query)
    {
        return $query->where('publish_at', '<=', Carbon::now());
    }

    /**
     * Sort the entities by their publish date.
     *
     * @return Builder
     */
    public function scopeLatestPublished(Builder $query)
    {
        return $query->latest('publish_at');
    }
}

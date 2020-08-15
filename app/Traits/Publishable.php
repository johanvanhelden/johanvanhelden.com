<?php

declare(strict_types=1);

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

trait Publishable
{
    /**
     * This method is called upon instantiation of the Eloquent Model.
     * It adds the "publish_at" field to the "$fillable" and "$casts" array of the model.
     */
    public function initializePublishable(): void
    {
        $this->fillable[] = 'publish_at';

        $this->casts['publish_at'] = 'datetime';
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('publish_at', '<=', Carbon::now());
    }

    public function scopeLatestPublished(Builder $query): void
    {
        $query->latest('publish_at');
    }
}

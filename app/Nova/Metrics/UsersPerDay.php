<?php

namespace App\Nova\Metrics;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Trend;

/**
 * Defines the users per day metric.
 */
class UsersPerDay extends Trend
{
    /**
     * Calculate the value of the metric.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->countByDays($request, User::class);
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            30 => __('nova-metric.ranges.30_days'),
            60 => __('nova-metric.ranges.60_days'),
            90 => __('nova-metric.ranges.90_days'),
        ];
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'users-per-day';
    }
}

<?php

namespace App\Nova\Metrics;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Value;

/**
 * Defines the new users metric.
 */
class NewUsers extends Value
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
        return $this->count($request, User::class);
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            30    => __('nova-metric.ranges.30_days'),
            60    => __('nova-metric.ranges.60_days'),
            365   => __('nova-metric.ranges.365_days'),
            'MTD' => __('nova-metric.ranges.mtd'),
            'QTD' => __('nova-metric.ranges.qtd'),
            'YTD' => __('nova-metric.ranges.ytd'),
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
        return 'new-users';
    }
}

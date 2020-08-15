<?php

declare(strict_types=1);

namespace App\Nova\Metrics;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Value;

class NewUsers extends Value
{
    /** @return mixed */
    public function calculate(Request $request)
    {
        return $this->count($request, User::class);
    }

    public function ranges(): array
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

    public function cacheFor(): Carbon
    {
        return Carbon::now()->addMinutes(5);
    }

    public function uriKey(): string
    {
        return 'new-users';
    }
}

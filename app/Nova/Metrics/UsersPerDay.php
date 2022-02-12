<?php

declare(strict_types=1);

namespace App\Nova\Metrics;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Trend;

class UsersPerDay extends Trend
{
    public function calculate(Request $request): mixed
    {
        return $this->countByDays($request, User::class);
    }

    public function ranges(): array
    {
        return [
            30 => __('nova-metric.ranges.30_days'),
            60 => __('nova-metric.ranges.60_days'),
            90 => __('nova-metric.ranges.90_days'),
        ];
    }

    public function cacheFor(): Carbon
    {
        return Carbon::now()->addMinutes(5);
    }

    public function uriKey(): string
    {
        return 'users-per-day';
    }
}

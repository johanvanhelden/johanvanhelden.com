<?php

declare(strict_types=1);

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Actions\ActionResource;

class Action extends ActionResource
{
    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public static function availableForNavigation(Request $request): bool
    {
        return true;
    }

    public static function group(): string
    {
        return __('nova-group.system');
    }
}

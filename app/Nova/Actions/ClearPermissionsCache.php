<?php

declare(strict_types=1);

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Spatie\Permission\PermissionRegistrar;

class ClearPermissionsCache extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function name(): string
    {
        return __('nova-action.clear_permission_cache');
    }

    public function handle(ActionFields $fields, Collection $models): mixed
    {
        App::make(PermissionRegistrar::class)->forgetCachedPermissions();

        return Action::message(__('message.cache.cleared'));
    }
}

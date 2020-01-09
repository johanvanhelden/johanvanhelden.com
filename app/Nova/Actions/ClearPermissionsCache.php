<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Spatie\Permission\PermissionRegistrar;

/**
 * Clears the permissions cache.
 */
class ClearPermissionsCache extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Get the displayable name of the action.
     *
     * @return string
     */
    public function name()
    {
        return __('nova-action.clear_permission_cache');
    }

    /**
     * Perform the action on the given models.
     *
     * @param \Laravel\Nova\Fields\ActionFields $fields
     * @param \Illuminate\Support\Collection    $models
     *
     * @return mixed
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        App::make(PermissionRegistrar::class)->forgetCachedPermissions();

        return Action::message(__('message.cache.cleared'));
    }
}

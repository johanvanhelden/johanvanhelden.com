<?php

declare(strict_types=1);

namespace App\Nova\Actions;

use App\Actions\User\SendSetAccountPassword as SendSetAccountPasswordAction;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class SendSetAccountPassword extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function name(): string
    {
        return __('nova-action.send_set_account_password');
    }

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $action = App::make(SendSetAccountPasswordAction::class);

        foreach ($models as $user) {
            $action->execute($user);
        }
    }
}

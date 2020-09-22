<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Subscriber\AskForConfirmation;
use App\Actions\Subscriber\ConfirmSubscriber;
use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SubscriberController extends Controller
{
    /** @return RedirectResponse|View */
    public function edit(string $uuid, string $secret)
    {
        $subscriber = $this->getSubscriber($uuid, $secret);

        if (!$subscriber->is_confirmed) {
            (new AskForConfirmation())->execute($subscriber);

            flash(__('message.subscription.unconfirmed'), 'info');

            return redirect()->route('page.home');
        }

        return view('subscriber.edit', [
            'subscriber' => $subscriber,
        ]);
    }

    public function confirm(string $uuid, string $secret, ConfirmSubscriber $action): RedirectResponse
    {
        $subscriber = $this->getSubscriber($uuid, $secret);

        $action->execute($subscriber);

        flash(__('message.subscription.confirmed'), 'success');

        return redirect($subscriber->manage_subscription_url);
    }

    private function getSubscriber(string $uuid, string $secret): Subscriber
    {
        return Subscriber::where('uuid', $uuid)->where('secret', $secret)
            ->firstOrFail();
    }
}

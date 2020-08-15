<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Subscriber\AskForConfirmation;
use App\Actions\Subscriber\ConfirmSubscriber;
use App\Actions\Subscriber\CreateSubscriber;
use App\Actions\Subscriber\DeleteSubscriber;
use App\Actions\Subscriber\UpdateSubscriber;
use App\Http\Requests\Subscriber\StoreRequest;
use App\Http\Requests\Subscriber\UpdateRequest;
use App\Http\Resources\SubscriberResource;
use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SubscriberController extends Controller
{
    public function store(
        StoreRequest $request,
        CreateSubscriber $createAction,
        AskForConfirmation $confirmationAction
    ): RedirectResponse {
        $subscriber = Subscriber::where('email', $request->email)->first();
        if ($subscriber && !$subscriber->is_confirmed) {
            $confirmationAction->execute($subscriber);
        }

        if (!$subscriber) {
            $createAction->execute($request->validated());
        }

        flash(__('message.subscription.requested'), 'success');

        return redirect()->back();
    }

    /** @return RedirectResponse|Response */
    public function edit(string $uuid, string $secret)
    {
        $subscriber = $this->getSubscriber($uuid, $secret);

        if (!$subscriber->is_confirmed) {
            return $this->handleNotConfirmed($subscriber);
        }

        return Inertia::render('Subscriber/Edit', [
            'subscriber' => new SubscriberResource($subscriber),
        ]);
    }

    public function update(
        string $uuid,
        string $secret,
        UpdateRequest $request,
        UpdateSubscriber $action
    ): RedirectResponse {
        $subscriber = $this->getSubscriber($uuid, $secret);

        if (!$subscriber->is_confirmed) {
            return $this->handleNotConfirmed($subscriber);
        }

        $action->execute($subscriber, $request->validated());

        $subscriber->refresh();

        flash(__('message.saved'), 'success');

        return redirect($subscriber->manage_subscription_url);
    }

    public function destroy(string $uuid, string $secret, DeleteSubscriber $action): RedirectResponse
    {
        $subscriber = $this->getSubscriber($uuid, $secret);

        if (!$subscriber->is_confirmed) {
            return $this->handleNotConfirmed($subscriber);
        }

        $action->execute($subscriber);

        flash(__('message.subscription.deleted'), 'success');

        return redirect()->route('page.home');
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

    private function handleNotConfirmed(Subscriber $subscriber): RedirectResponse
    {
        (new AskForConfirmation())->execute($subscriber);

        flash(__('message.subscription.unconfirmed'), 'info');

        return redirect()->route('page.home');
    }
}

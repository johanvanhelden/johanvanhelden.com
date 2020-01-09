<?php

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
use Inertia\Inertia;

/**
 * The subscription controller.
 */
class SubscriberController extends Controller
{
    /**
     * Executes the request to store a subscriber, if not yet subscribed.
     *
     * @param StoreRequest       $request
     * @param CreateSubscriber   $createAction
     * @param AskForConfirmation $confirmationAction
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(
        StoreRequest $request,
        CreateSubscriber $createAction,
        AskForConfirmation $confirmationAction
    ) {
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

    /**
     * Renders the subscriber's management page.
     *
     * @param string $uuid
     * @param string $secret
     *
     * @return \Inertia\Response
     */
    public function edit(string $uuid, string $secret)
    {
        $subscriber = $this->getSubscriber($uuid, $secret);

        if (!$subscriber->is_confirmed) {
            return $this->handleNotConfirmed($subscriber);
        }

        SubscriberResource::withoutWrapping();

        return Inertia::render('Subscriber/Edit', [
            'subscriber' => new SubscriberResource($subscriber),
        ]);
    }

    /**
     * Executes the request to update a subscriber.
     *
     * @param string           $uuid
     * @param string           $secret
     * @param UpdateRequest    $request
     * @param UpdateSubscriber $action
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(string $uuid, string $secret, UpdateRequest $request, UpdateSubscriber $action)
    {
        $subscriber = $this->getSubscriber($uuid, $secret);

        if (!$subscriber->is_confirmed) {
            return $this->handleNotConfirmed($subscriber);
        }

        $action->execute($subscriber, $request->validated());

        $subscriber->refresh();

        flash(__('message.saved'), 'success');

        return redirect($subscriber->manage_subscription_url);
    }

    /**
     * Executes the request to delete a subscriber.
     *
     * @param string           $uuid
     * @param string           $secret
     * @param DeleteSubscriber $action
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $uuid, string $secret, DeleteSubscriber $action)
    {
        $subscriber = $this->getSubscriber($uuid, $secret);

        if (!$subscriber->is_confirmed) {
            return $this->handleNotConfirmed($subscriber);
        }

        $action->execute($subscriber);

        flash(__('message.subscription.deleted'), 'success');

        return redirect()->route('page.home');
    }

    /**
     * Executes the request to confirm a subscriber.
     *
     * @param string            $uuid
     * @param string            $secret
     * @param ConfirmSubscriber $action
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirm(string $uuid, string $secret, ConfirmSubscriber $action)
    {
        $subscriber = $this->getSubscriber($uuid, $secret);

        $action->execute($subscriber);

        flash(__('message.subscription.confirmed'), 'success');

        return redirect($subscriber->manage_subscription_url);
    }

    /**
     * Get the subscriber.
     *
     * @param string $uuid
     * @param string $secret
     *
     * @return Subscriber
     */
    private function getSubscriber(string $uuid, string $secret)
    {
        return Subscriber::where('uuid', $uuid)->where('secret', $secret)
            ->firstOrFail();
    }

    /**
     * Handles a unconfirmed subscriber visit.
     *
     * @param Subscriber $subscriber
     */
    private function handleNotConfirmed(Subscriber $subscriber)
    {
        (new AskForConfirmation())->execute($subscriber);

        flash(__('message.subscription.unconfirmed'), 'info');

        return redirect()->route('page.home');
    }
}

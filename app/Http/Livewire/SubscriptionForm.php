<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Actions\Subscriber\DeleteSubscriber;
use App\Actions\Subscriber\UpdateSubscriber;
use App\Models\Subscriber;
use App\Traits\Livewire\Notifies;
use App\Traits\Livewire\Validates;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Redirector;

class SubscriptionForm extends Component
{
    use Validates, Notifies;

    public ?Subscriber $subscriber = null;

    public function render(): View
    {
        return view('livewire.subscription-form');
    }

    public function update(UpdateSubscriber $action): void
    {
        $data = $this->validate(null, [], $this->attributesForModel('subscriber'));

        $action->execute($this->subscriber, $data);

        $this->notify('success', __('message.saved'));
    }

    public function rules(): array
    {
        $unique = 'unique';
        if ($this->subscriber) {
            $unique = Rule::unique('subscribers', 'email')->ignore($this->subscriber->id, 'id');
        }

        $rules = [
            'subscriber.name'  => ['required', 'min:2', 'db_string'],
            'subscriber.email' => ['required', 'email', $unique],
        ];

        return $rules;
    }

    public function unsubscribe(DeleteSubscriber $action): Redirector
    {
        $action->execute($this->subscriber);

        $this->notify('success', __('message.subscription.deleted'));

        return redirect()->route('page.home');
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Actions\Subscriber\AskForConfirmation;
use App\Actions\Subscriber\CreateSubscriber;
use App\Models\Subscriber;
use App\Traits\Livewire\Notifies;
use Illuminate\View\View;
use Livewire\Component;

class SubscribeForm extends Component
{
    use Notifies;

    public string $name = '';

    public string $email = '';

    public function render(): View
    {
        return view('livewire.subscribe-form');
    }

    public function store(CreateSubscriber $createAction, AskForConfirmation $confirmationAction): void
    {
        $data = $this->validate(null, [], __('subscriber.attributes'));

        $subscriber = Subscriber::where('email', $data['email'])->first();
        if ($subscriber && !$subscriber->is_confirmed) {
            $confirmationAction->execute($subscriber);
        }

        if (!$subscriber) {
            $createAction->execute($data);
        }

        $this->reset();

        $this->notify(
            'success',
            __('message.subscription.confirmation-required'),
            __('message.subscription.requested')
        );
    }

    public function rules(): array
    {
        return [
            'name'  => ['required', 'db_string'],
            'email' => ['required', 'email'],
        ];
    }
}

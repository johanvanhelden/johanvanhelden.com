<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;

class NotificationContainer extends Component
{
    public Collection $messages;

    /** @var array */
    protected $listeners = ['notify', 'dismissNotification'];

    public function mount(): void
    {
        $this->messages = session('flash_notification', new Collection())->map(function (object $message) {
            return [
                'uuid'        => Str::uuid()->toString(),
                'type'        => $message->level,
                'title'       => $message->message,
                'description' => null,
            ];
        });

        session()->forget('flash_notification');
    }

    public function render(): View
    {
        return view('livewire.notification-container');
    }

    public function notify(string $type, string $message, ?string $description = null): void
    {
        $this->messages->push([
            'uuid'        => Str::uuid()->toString(),
            'type'        => $type,
            'title'       => $message,
            'description' => $description,
        ]);
    }

    public function dismissNotification(string $uuid): void
    {
        $this->messages = $this->messages->filter(fn ($message) => $message['uuid'] !== $uuid);
    }
}

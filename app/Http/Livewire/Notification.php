<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use Illuminate\View\View;
use Livewire\Component;

class Notification extends Component
{
    public string $uuid;
    public string $type;
    public string $title;
    public ?string $description;

    public function render(): View
    {
        return view('livewire.notification');
    }

    public function dismiss(): void
    {
        $this->emitUp('dismissNotification', $this->uuid);
    }
}

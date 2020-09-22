<?php

declare(strict_types=1);

namespace App\Traits\Livewire;

trait Notifies
{
    public function notify(string $type, string $title, ?string $description = null): void
    {
        flash($title, $type);

        $this->emit('notify', $type, $title, $description);
    }
}

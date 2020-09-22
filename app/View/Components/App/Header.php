<?php

declare(strict_types=1);

namespace App\View\Components\App;

use Illuminate\View\Component;
use Illuminate\View\View;

class Header extends Component
{
    public bool $expandedHeader;

    public function __construct(bool $expandedHeader = false)
    {
        $this->expandedHeader = $expandedHeader;
    }

    public function render(): View
    {
        return view('components.app.header');
    }
}

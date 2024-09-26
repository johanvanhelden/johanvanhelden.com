<?php

declare(strict_types=1);

namespace Tests\Feature\Page\Home;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class HomeTest extends TestCase
{
    #[Test]
    public function it_works(): void
    {
        $this->get(route('page.home'))
            ->assertOk();
    }
}

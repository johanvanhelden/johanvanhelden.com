<?php

declare(strict_types=1);

namespace Tests\Feature\Page\Home;

use Tests\TestCase;

class HomeTest extends TestCase
{
    /** @test */
    public function it_works(): void
    {
        $this->get(route('page.home'))
            ->assertOk();
    }
}

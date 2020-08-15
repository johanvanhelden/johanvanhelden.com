<?php

declare(strict_types=1);

namespace Tests\Unit;

use Illuminate\Support\Facades\App;
use Tests\TestCase;

class BootstrapperTest extends TestCase
{
    /** @test */
    public function it_sets_the_custom_public_folder(): void
    {
        $this->assertEquals(base_path('public_html'), public_path());
        $this->assertEquals(base_path('public_html'), App::publicPath());
    }
}

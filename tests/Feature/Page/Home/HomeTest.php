<?php

namespace Tests\Feature\Page\Home;

use Tests\TestCase;

/**
 * Test to ensure the home page is working properly.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class HomeTest extends TestCase
{
    /** @test */
    public function it_works()
    {
        $response = $this->get(route('page.home'));

        $response->assertOk();
    }
}

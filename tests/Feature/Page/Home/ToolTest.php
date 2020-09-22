<?php

declare(strict_types=1);

namespace Tests\Feature\Page\Home;

use App\Models\Tool;
use Tests\TestCase;

class ToolTest extends TestCase
{
    /** @test */
    public function has_tools(): void
    {
        Tool::factory()->count(2)->published()->create();

        $this->get(route('page.home'))
            ->assertViewHas('tools');
    }

    /** @test */
    public function it_only_lists_published(): void
    {
        $publishedTools = Tool::factory()->count(2)->published()->create();
        Tool::factory()->count(4)->published(false)->create();

        $response = $this->get(route('page.home'));

        $viewTools = $response->viewData('tools');

        $this->assertEquals(
            $publishedTools->pluck('id')->toArray(),
            $viewTools->pluck('id')->toArray()
        );
    }

    /** @test */
    public function are_sorted_by_order(): void
    {
        Tool::factory()->count(10)->published()->create();

        // reverse the order so we can actually test the custom order
        $order = 10;
        foreach (Tool::all() as $tool) {
            $tool->order = $order;
            $tool->save();

            $order--;
        }

        $sortedTools = Tool::get()->sortBy('order');

        $response = $this->get(route('page.home'));

        $viewTools = $response->viewData('tools');

        $this->assertEquals(
            $sortedTools->pluck('id')->toArray(),
            $viewTools->pluck('id')->toArray()
        );
    }
}

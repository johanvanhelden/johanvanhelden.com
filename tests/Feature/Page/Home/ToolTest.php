<?php

declare(strict_types=1);

namespace Tests\Feature\Page\Home;

use App\Http\Resources\ToolResource;
use App\Models\Tool;
use Tests\TestCase;

class ToolTest extends TestCase
{
    /** @test */
    public function it_only_lists_published(): void
    {
        $publishedTools = factory(Tool::class, 2)->state('published')->create();
        factory(Tool::class, 4)->state('unpublished')->create();

        $response = $this->get(route('page.home'));

        $response->assertPropCount('tools', 2);
        $response->assertPropValue('tools', ToolResource::collection($publishedTools));
    }

    /** @test */
    public function are_sorted_by_order(): void
    {
        factory(Tool::class, 10)->state('published')->create();

        // reverse the order so we can actually test the custom order
        $order = 10;
        foreach (Tool::all() as $tool) {
            $tool->order = $order;
            $tool->save();

            $order--;
        }

        $sortedTools = Tool::get()->sortBy('order');

        $response = $this->get(route('page.home'));

        $response->assertPropCount('tools', 10);
        $response->assertPropValue('tools', ToolResource::collection($sortedTools));
    }
}

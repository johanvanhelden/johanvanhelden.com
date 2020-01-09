<?php

namespace Tests\Feature\Page\Home;

use App\Http\Resources\ToolResource;
use App\Models\Tool;
use Tests\TestCase;

/**
 * Test to ensure the home page's tools are working properly.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class ToolTest extends TestCase
{
    /** @test */
    public function it_only_lists_published()
    {
        $publishedTools = factory(Tool::class, 2)->state('published')->create();
        factory(Tool::class, 4)->state('unpublished')->create();

        $response = $this->get(route('page.home'));

        $response->assertPropCount('tools.data', 2);
        $response->assertPropResourceCollection('tools', ToolResource::collection($publishedTools));
    }

    /** @test */
    public function are_sorted_by_order()
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

        $response->assertPropCount('tools.data', 10);
        $response->assertPropResourceCollection('tools', ToolResource::collection($sortedTools));
    }
}

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
        $tools = Tool::factory()->count(2)->published()->create();
        Tool::factory()->count(4)->published(false)->create();

        $response = $this->get(route('page.home'));

        $response->assertPropCount('tools', 2);
        $response->assertPropValue('tools', ToolResource::collection($tools));
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

        $response->assertPropCount('tools', 10);
        $response->assertPropValue('tools', ToolResource::collection($sortedTools));
    }
}

<?php

declare(strict_types=1);

namespace Tests\Feature\Page\Home;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ToolTest extends TestCase
{
    /** @test */
    public function has_tools(): void
    {
        $this->get(route('page.home'))
            ->assertViewHas('tools');
    }

    /** @test */
    public function it_only_lists_published(): void
    {
        File::partialMock()
            ->shouldReceive('get')
            ->with(resource_path('data/tools.json'))
            ->andReturn(json_encode([
                [
                    'name'       => 'not-published',
                    'image'      => '',
                    'url'        => '',
                    'publish_at' => Carbon::tomorrow()->toString(),
                    'created_at' => Carbon::yesterday()->toString(),
                    'updated_at' => Carbon::yesterday()->toString(),
                ],
                [
                    'name'       => 'published',
                    'image'      => '',
                    'url'        => '',
                    'publish_at' => Carbon::yesterday()->toString(),
                    'created_at' => Carbon::yesterday()->toString(),
                    'updated_at' => Carbon::yesterday()->toString(),
                ],
            ]));

        $response = $this->get(route('page.home'));

        $viewTools = $response->viewData('tools');

        $this->assertCount(1, $viewTools);

        $this->assertEquals(
            ['published'],
            $viewTools->pluck('name')->toArray()
        );
    }
}

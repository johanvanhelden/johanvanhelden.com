<?php

declare(strict_types=1);

namespace Tests\Feature\Page\Home;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ToolTest extends TestCase
{
    #[Test]
    public function has_tools(): void
    {
        $this->get(route('page.home'))
            ->assertViewHas('tools');
    }

    #[Test]
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

        /** @var \Illuminate\Support\Collection<int, array<string, mixed>> $viewTools */
        $viewTools = $response->viewData('tools');

        $this->assertInstanceOf(Collection::class, $viewTools);
        $this->assertCount(1, $viewTools);

        $this->assertEquals(
            ['published'],
            $viewTools->pluck('name')->toArray()
        );
    }
}

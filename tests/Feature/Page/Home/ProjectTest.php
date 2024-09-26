<?php

declare(strict_types=1);

namespace Tests\Feature\Page\Home;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    #[Test]
    public function has_projects(): void
    {
        $this->get(route('page.home'))
            ->assertViewHas('projects');
    }

    #[Test]
    public function it_only_lists_published(): void
    {
        File::partialMock()
            ->shouldReceive('get')
            ->with(resource_path('data/projects.json'))
            ->andReturn(json_encode([
                [
                    'name'       => 'not-published',
                    'excerpt'    => '',
                    'slug'       => '',
                    'publish_at' => Carbon::tomorrow()->toString(),
                    'created_at' => Carbon::yesterday()->toString(),
                    'updated_at' => Carbon::yesterday()->toString(),
                ],
                [
                    'name'       => 'published',
                    'excerpt'    => '',
                    'slug'       => '',
                    'publish_at' => Carbon::yesterday()->toString(),
                    'created_at' => Carbon::yesterday()->toString(),
                    'updated_at' => Carbon::yesterday()->toString(),
                ],
            ]));

        $response = $this->get(route('page.home'));

        /** @var \Illuminate\Support\Collection<int, array<string, mixed>> $viewProjects */
        $viewProjects = $response->viewData('projects');

        $this->assertInstanceOf(Collection::class, $viewProjects);
        $this->assertCount(1, $viewProjects);

        $this->assertEquals(
            ['published'],
            $viewProjects->pluck('name')->toArray()
        );
    }
}

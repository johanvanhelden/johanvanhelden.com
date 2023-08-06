<?php

declare(strict_types=1);

namespace Tests\Feature\Page\Home;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    /** @test */
    public function has_projects(): void
    {
        $this->get(route('page.home'))
            ->assertViewHas('projects');
    }

    /** @test */
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

        $viewProjects = $response->viewData('projects');

        $this->assertCount(1, $viewProjects);

        $this->assertEquals(
            ['published'],
            $viewProjects->pluck('name')->toArray()
        );
    }
}

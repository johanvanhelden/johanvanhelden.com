<?php

namespace Tests\Feature\Page\Home;

use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Carbon\Carbon;
use Tests\TestCase;

/**
 * Test to ensure the home page's projects are working properly.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class ProjectTest extends TestCase
{
    /** @test */
    public function it_only_lists_published()
    {
        $projects = factory(Project::class, 2)->state('published')->create();
        factory(Project::class, 4)->state('unpublished')->create();

        $sortedProjects = $projects->sortByDesc('publish_at');

        $response = $this->get(route('page.home'));

        $response->assertPropCount('projects.data', 2);
        $response->assertPropResourceCollection('projects', ProjectResource::collection($sortedProjects));
    }

    /** @test */
    public function are_sorted_by_publish_date()
    {
        $projects = collect();

        $projects->push(
            factory(Project::class)->state('published')->create([
                'publish_at' => Carbon::createFromFormat('d-m-Y H:i', '10-10-1989 09:00'),
            ])
        );

        $projects->push(
            factory(Project::class)->state('published')->create([
                'publish_at' => Carbon::createFromFormat('d-m-Y H:i', '11-12-2000 10:15'),
            ])
        );

        $projects->push(
            factory(Project::class)->state('published')->create([
                'publish_at' => Carbon::createFromFormat('d-m-Y H:i', '11-12-2000 08:15'),
            ])
        );

        $sortedProjects = $projects->sortByDesc('publish_at');

        $response = $this->get(route('page.home'));

        $response->assertPropCount('projects.data', 3);
        $response->assertPropResourceCollection('projects', ProjectResource::collection($sortedProjects));
    }
}

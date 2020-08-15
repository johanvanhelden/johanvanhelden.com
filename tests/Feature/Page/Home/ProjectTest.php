<?php

declare(strict_types=1);

namespace Tests\Feature\Page\Home;

use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Carbon\Carbon;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    /** @test */
    public function it_only_lists_published(): void
    {
        $projects = factory(Project::class, 2)->state('published')->create();
        factory(Project::class, 4)->state('unpublished')->create();

        $sortedProjects = $projects->sortByDesc('publish_at');

        $response = $this->get(route('page.home'));

        $response->assertPropCount('projects', 2);
        $response->assertPropValue('projects', ProjectResource::collection($sortedProjects));
    }

    /** @test */
    public function are_sorted_by_publish_date(): void
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

        $response->assertPropCount('projects', 3);
        $response->assertPropValue('projects', ProjectResource::collection($sortedProjects));
    }
}

<?php

declare(strict_types=1);

namespace Tests\Feature\Page\Home;

use App\Models\Project;
use Carbon\Carbon;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    /** @test */
    public function has_projects(): void
    {
        Project::factory()->count(2)->published()->create();

        $this->get(route('page.home'))
            ->assertViewHas('projects');
    }

    /** @test */
    public function it_only_lists_published(): void
    {
        $publishedProjects = Project::factory()->count(2)->published()->create();
        Project::factory()->count(4)->published(false)->create();

        $response = $this->get(route('page.home'));

        $viewProjects = $response->viewData('projects');

        $this->assertCount(2, $viewProjects);

        foreach ($viewProjects as $viewProject) {
            $this->assertTrue($publishedProjects->contains($viewProject));
        }
    }

    /** @test */
    public function are_sorted_by_publish_date(): void
    {
        $projects = collect();

        $projects->push(
            Project::factory()->published()->create([
                'publish_at' => Carbon::createFromFormat('d-m-Y H:i', '10-10-1989 09:00'),
            ])
        );

        $projects->push(
            Project::factory()->published()->create([
                'publish_at' => Carbon::createFromFormat('d-m-Y H:i', '11-12-2000 10:15'),
            ])
        );

        $projects->push(
            Project::factory()->published()->create([
                'publish_at' => Carbon::createFromFormat('d-m-Y H:i', '11-12-2000 08:15'),
            ])
        );

        $sortedProjects = $projects->sortByDesc('publish_at');

        $response = $this->get(route('page.home'));

        $viewProjects = $response->viewData('projects');

        $this->assertEquals(
            $sortedProjects->pluck('id')->toArray(),
            $viewProjects->pluck('id')->toArray()
        );
    }
}

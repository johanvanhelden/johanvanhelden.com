<?php

namespace Tests\Feature\Page\Project;

use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Tests\TestCase;

/**
 * Test to ensure the project show page is working properly.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class ShowTest extends TestCase
{
    /** @test */
    public function it_works()
    {
        $project = factory(Project::class)->state('published')->create();

        $response = $this->get(route('project.show', $project));

        $response->assertOk();
    }

    /** @test */
    public function it_contains_the_project_data()
    {
        $project = factory(Project::class)->state('published')->create();

        $response = $this->get(route('project.show', $project));

        $response->assertPropResourceCollection('project', new ProjectResource($project));
    }

    /** @test */
    public function an_unpublished_project_can_not_be_viewed()
    {
        $this->withoutExceptionHandling();
        $this->expectException(AuthorizationException::class);

        $project = factory(Project::class)->state('unpublished')->create();

        $this->get(route('project.show', $project));
    }

    /** @test */
    public function a_published_project_can_not_be_viewed_if_in_the_future()
    {
        $this->withoutExceptionHandling();
        $this->expectException(AuthorizationException::class);

        $project = factory(Project::class)->state('published')->create([
            'publish_at' => Carbon::now()->addDay(),
        ]);

        $this->get(route('project.show', $project));
    }
}

<?php

declare(strict_types=1);

namespace Tests\Feature\Page\Project;

use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Tests\TestCase;

class ShowTest extends TestCase
{
    /** @test */
    public function it_works(): void
    {
        $project = Project::factory()->published()->create();

        $response = $this->get(route('project.show', $project));

        $response->assertOk();
    }

    /** @test */
    public function it_contains_the_project_data(): void
    {
        $project = Project::factory()->published()->create();

        $response = $this->get(route('project.show', $project));

        $response->assertPropValue('project', new ProjectResource($project));
    }

    /** @test */
    public function an_unpublished_project_can_not_be_viewed(): void
    {
        $this->withoutExceptionHandling();
        $this->expectException(AuthorizationException::class);

        $project = Project::factory()->published(false)->create();

        $this->get(route('project.show', $project));
    }

    /** @test */
    public function a_published_project_can_not_be_viewed_if_in_the_future(): void
    {
        $this->withoutExceptionHandling();
        $this->expectException(AuthorizationException::class);

        $project = Project::factory()->published()->create([
            'publish_at' => Carbon::now()->addDay(),
        ]);

        $this->get(route('project.show', $project));
    }
}

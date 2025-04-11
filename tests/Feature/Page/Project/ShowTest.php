<?php

declare(strict_types=1);

namespace Tests\Feature\Page\Project;

use App\Data\Project;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ShowTest extends TestCase
{
    #[Test]
    public function it_works(): void
    {
        $project = Project::all()[0];

        $this
            ->get(route('project.show', $project['slug']))

            ->assertOk();
    }

    #[Test]
    public function in_invalid_project_triggers_a_404(): void
    {
        $this
            ->get(route('project.show', 'fake-project'))

            ->assertNotFound();
    }

    #[Test]
    public function it_contains_the_project_data(): void
    {
        $project = Project::all()[0];

        $this
            ->get(route('project.show', $project['slug']))

            ->assertViewHas('project', $project);
    }

    #[Test]
    public function an_unpublished_project_can_not_be_viewed(): void
    {
        File::partialMock()
            ->shouldReceive('get')
            ->with(resource_path('data/projects.json'))
            ->andReturn(json_encode([
                [
                    'name' => 'test',
                    'slug' => 'test',
                    'url'  => '',

                    'publish_at' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
            ]));

        $this
            ->get(route('project.show', 'test'))

            ->assertStatus(403);
    }

    #[Test]
    public function a_published_project_can_not_be_viewed_if_in_the_future(): void
    {
        File::partialMock()
            ->shouldReceive('get')
            ->with(resource_path('data/projects.json'))
            ->andReturn(json_encode([
                [
                    'name' => 'test',
                    'slug' => 'test',
                    'url'  => '',

                    'publish_at' => Carbon::now()->addDay(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::createFromFormat('d-m-Y', '10-10-2017'),
                ],
            ]));

        $this
            ->get(route('project.show', 'test'))

            ->assertStatus(403);
    }
}

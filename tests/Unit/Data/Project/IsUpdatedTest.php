<?php

declare(strict_types=1);

namespace Tests\Unit\Data\Project;

use App\Data\Project;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class IsUpdatedTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(Carbon::parse('10-10-1989 06:45:10'));
    }

    /** @test */
    public function is_marked_if_edited_the_day_after_being_published(): void
    {
        File::partialMock()
            ->shouldReceive('get')
            ->with(resource_path('data/projects.json'))
            ->andReturn(json_encode([
                [
                    'slug' => 'test',

                    'publish_at' => Carbon::now()->startOfDay(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()->addDay()->addHours(4),
                ],
            ]));

        $project = Project::bySlug('test');

        $this->assertTrue($project['is_updated']);
    }

    /** @test */
    public function is_not_marked_if_not_published(): void
    {
        File::partialMock()
            ->shouldReceive('get')
            ->with(resource_path('data/projects.json'))
            ->andReturn(json_encode([
                [
                    'slug' => 'test',

                    'created_at' => Carbon::now(),
                    'publish_at' => null,
                    'updated_at' => Carbon::now()->addDay()->addHours(4),
                ],
            ]));

        $project = Project::bySlug('test');

        $this->assertFalse($project['is_updated']);
    }

    /** @test */
    public function is_not_marked_if_edit_on_the_same_day_as_being_published(): void
    {
        File::partialMock()
            ->shouldReceive('get')
            ->with(resource_path('data/projects.json'))
            ->andReturn(json_encode([
                [
                    'slug' => 'test',

                    'publish_at' => Carbon::now()->startOfDay(),
                    'created_at' => Carbon::now()->startOfDay(),
                    'updated_at' => Carbon::now()->startOfDay()->addHours(4),
                ],
            ]));

        $project = Project::bySlug('test');

        $this->assertFalse($project['is_updated']);
    }

    /** @test */
    public function is_not_marked_if_updated_before_the_day_of_publishing(): void
    {
        File::partialMock()
            ->shouldReceive('get')
            ->with(resource_path('data/projects.json'))
            ->andReturn(json_encode([
                [
                    'slug' => 'test',

                    'publish_at' => Carbon::createFromFormat('d-m-Y', '10-10-2019'),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::createFromFormat('d-m-Y', '10-10-2017'),
                ],
            ]));

        $project = Project::bySlug('test');

        $this->assertFalse($project['is_updated']);
    }
}

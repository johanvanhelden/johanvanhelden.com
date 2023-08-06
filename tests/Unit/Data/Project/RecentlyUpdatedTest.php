<?php

declare(strict_types=1);

namespace Tests\Unit\Data\Project;

use App\Data\Project;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class RecentlyUpdatedTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(Carbon::parse('10-10-1989 06:45:10'));
    }

    /** @test */
    public function is_marked_if_updated_7_days_ago(): void
    {
        File::partialMock()
            ->shouldReceive('get')
            ->with(resource_path('data/projects.json'))
            ->andReturn(json_encode([
                [
                    'slug' => 'test',

                    'publish_at' => Carbon::now()->subWeeks(2)->toString(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()->subDays(7)->toString(),
                ],
            ]));

        $project = Project::bySlug('test');

        $this->assertTrue($project['is_recently_updated']);
    }

    /** @test */
    public function is_marked_if_updated_3_days_ago(): void
    {
        File::partialMock()
            ->shouldReceive('get')
            ->with(resource_path('data/projects.json'))
            ->andReturn(json_encode([
                [
                    'slug' => 'test',

                    'publish_at' => Carbon::now()->subWeeks(2),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()->subDays(3),
                ],
            ]));

        $project = Project::bySlug('test');

        $this->assertTrue($project['is_recently_updated']);
    }

    /** @test */
    public function is_marked_if_updated_1_day_ago(): void
    {
        File::partialMock()
            ->shouldReceive('get')
            ->with(resource_path('data/projects.json'))
            ->andReturn(json_encode([
                [
                    'slug' => 'test',

                    'publish_at' => Carbon::now()->subWeeks(2),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()->subDays(1),
                ],
            ]));

        $project = Project::bySlug('test');

        $this->assertTrue($project['is_recently_updated']);
    }

    /** @test */
    public function is_not_marked_if_updated_on_the_same_day_as_publishing(): void
    {
        File::partialMock()
            ->shouldReceive('get')
            ->with(resource_path('data/projects.json'))
            ->andReturn(json_encode([
                [
                    'slug' => 'test',

                    'publish_at' => Carbon::now()->startOfDay(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()->endOfDay(),
                ],
            ]));

        $project = Project::bySlug('test');

        $this->assertFalse($project['is_recently_updated']);
    }

    /** @test */
    public function is_not_marked_if_updated_8_days_ago(): void
    {
        File::partialMock()
            ->shouldReceive('get')
            ->with(resource_path('data/projects.json'))
            ->andReturn(json_encode([
                [
                    'slug' => 'test',

                    'publish_at' => Carbon::now()->subWeeks(2),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()->subDays(8),
                ],
            ]));

        $project = Project::bySlug('test');

        $this->assertFalse($project['is_recently_updated']);
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

                    'publish_at' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()->subDays(8),
                ],
            ]));

        $project = Project::bySlug('test');

        $this->assertFalse($project['is_recently_updated']);
    }

    /** @test */
    public function is_not_marked_if_not_updated(): void
    {
        File::partialMock()
            ->shouldReceive('get')
            ->with(resource_path('data/projects.json'))
            ->andReturn(json_encode([
                [
                    'slug' => 'test',

                    'publish_at' => Carbon::now()->startOfDay(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
            ]));

        $project = Project::bySlug('test');

        $this->assertFalse($project['is_updated'], 'the project is marked is updated');
        $this->assertFalse($project['is_recently_updated'], 'the project is marked is recently updated');
    }
}

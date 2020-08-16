<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Project;
use Carbon\Carbon;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(Carbon::parse('10-10-1989 06:45:10'));
    }

    /** @test */
    public function is_not_marked_as_updated_if_not_published(): void
    {
        $project = factory(Project::class)->state('unpublished')->create();

        $this->assertFalse($project->is_updated);
    }

    /** @test */
    public function is_not_marked_as_updated_if_edit_on_the_same_day_as_being_published(): void
    {
        $project = factory(Project::class)->state('published')->create([
            'publish_at' => Carbon::now()->startOfDay(),
            'updated_at' => Carbon::now()->startOfDay()->addHours(4),
        ]);

        $this->assertFalse($project->is_updated);
    }

    /** @test */
    public function is_marked_as_updated_if_edited_the_day_after_being_published(): void
    {
        $project = factory(Project::class)->state('published')->create([
            'publish_at' => Carbon::now()->startOfDay(),
            'updated_at' => Carbon::now()->addDay()->addHours(4),
        ]);

        $this->assertTrue($project->is_updated);
    }

    /** @test */
    public function is_marked_as_recently_updated_if_edited_within_7_days_after_being_published(): void
    {
        $project = factory(Project::class)->state('published')->create([
            'publish_at' => Carbon::now()->startOfDay(),
            'updated_at' => Carbon::now()->addDay()->addHours(4),
        ]);

        $this->assertTrue($project->is_recently_updated);
    }

    /** @test */
    public function is_not_marked_as_recently_updated_if_edited_8_days_after_being_published(): void
    {
        $project = factory(Project::class)->state('published')->create([
            'publish_at' => Carbon::now()->startOfDay(),
            'updated_at' => Carbon::now()->addDays(8),
        ]);

        $this->assertFalse($project->is_recently_updated, 'the project is marked is recently updated');
    }

    /** @test */
    public function is_not_marked_as_recently_updated_if_not_updated(): void
    {
        $project = factory(Project::class)->create([
            'publish_at' => Carbon::now()->startOfDay(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $this->assertFalse($project->is_updated, 'the project is marked is updated');
        $this->assertFalse($project->is_recently_updated, 'the project is marked is recently updated');
    }
}

<?php

declare(strict_types=1);

namespace Tests\Unit\Project;

use App\Models\Project;
use Carbon\Carbon;
use Tests\TestCase;

class RecentlyUpdatedTest extends TestCase
{
    /** @test */
    public function is_marked_if_updated_if_7_days_ago(): void
    {
        $project = factory(Project::class)->state('published')->create([
            'publish_at' => Carbon::now()->subWeeks(2),
            'updated_at' => Carbon::now()->subDays(7),
        ]);

        $this->assertTrue($project->is_recently_updated);
    }

    /** @test */
    public function is_marked_if_updated_if_3_days_ago(): void
    {
        $project = factory(Project::class)->state('published')->create([
            'publish_at' => Carbon::now()->subWeeks(2),
            'updated_at' => Carbon::now()->subDays(3),
        ]);

        $this->assertTrue($project->is_recently_updated);
    }

    /** @test */
    public function is_marked_if_updated_if_1_day_ago(): void
    {
        $project = factory(Project::class)->state('published')->create([
            'publish_at' => Carbon::now()->subWeeks(2),
            'updated_at' => Carbon::now()->subDays(1),
        ]);

        $this->assertTrue($project->is_recently_updated);
    }

    /** @test */
    public function is_not_marked_if_updated_on_the_same_day_as_publishing(): void
    {
        $project = factory(Project::class)->state('published')->create([
            'publish_at' => Carbon::now()->startOfDay(),
            'updated_at' => Carbon::now()->endOfDay(),
        ]);

        $this->assertFalse($project->is_recently_updated);
    }

    /** @test */
    public function is_not_marked_if_updated_if_8_days_ago(): void
    {
        $project = factory(Project::class)->state('published')->create([
            'publish_at' => Carbon::now()->subWeeks(2),
            'updated_at' => Carbon::now()->subDays(8),
        ]);

        $this->assertFalse($project->is_recently_updated);
    }

    /** @test */
    public function is_not_marked_if_not_published(): void
    {
        $project = factory(Project::class)->state('unpublished')->create();

        $this->assertFalse($project->is_recently_updated);
    }
}

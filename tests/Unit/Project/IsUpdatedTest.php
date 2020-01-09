<?php

namespace Tests\Unit\Project;

use App\Models\Project;
use Carbon\Carbon;
use Tests\TestCase;

/**
 * Tests to ensure the project "is updated" logic is working properly.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class IsUpdatedTest extends TestCase
{
    /** @test */
    public function is_marked_as_updated_if_updated_after_the_day_of_publishing()
    {
        $project = factory(Project::class)->state('published')->create([
            'publish_at' => Carbon::createFromFormat('d-m-Y', '10-10-1989'),
            'updated_at' => Carbon::createFromFormat('d-m-Y', '10-10-2019'),
        ]);

        $this->assertTrue($project->is_updated);
    }

    /** @test */
    public function is_not_marked_as_updated_if_updated_on_the_day_of_publishing()
    {
        $project = factory(Project::class)->state('published')->create([
            'publish_at' => Carbon::createFromFormat('d-m-Y', '10-10-2019'),
            'updated_at' => Carbon::createFromFormat('d-m-Y', '10-10-2019'),
        ]);

        $this->assertFalse($project->is_updated);
    }

    /** @test */
    public function is_not_marked_as_updated_if_updated_before_the_day_of_publishing()
    {
        $project = factory(Project::class)->state('published')->create([
            'publish_at' => Carbon::createFromFormat('d-m-Y', '10-10-2019'),
            'updated_at' => Carbon::createFromFormat('d-m-Y', '10-10-2017'),
        ]);

        $this->assertFalse($project->is_updated);
    }
}

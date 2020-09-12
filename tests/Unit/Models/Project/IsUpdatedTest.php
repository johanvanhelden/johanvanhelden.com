<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Project;

use App\Models\Project;
use Carbon\Carbon;
use Tests\TestCase;

class IsUpdatedTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(Carbon::parse('10-10-1989 06:45:10'));
    }

    /** @test */
    public function is_marked_aif_edited_the_day_after_being_published(): void
    {
        $project = Project::factory()->published()->state([
            'publish_at' => Carbon::now()->startOfDay(),
            'updated_at' => Carbon::now()->addDay()->addHours(4),
        ])->create();

        $this->assertTrue($project->is_updated);
    }

    /** @test */
    public function is_not_marked_if_not_published(): void
    {
        $project = Project::factory()->published(false)->create();

        $this->assertFalse($project->is_updated);
    }

    /** @test */
    public function is_not_marked_if_edit_on_the_same_day_as_being_published(): void
    {
        $project = Project::factory()->published()->state([
            'publish_at' => Carbon::now()->startOfDay(),
            'updated_at' => Carbon::now()->startOfDay()->addHours(4),
        ])->create();

        $this->assertFalse($project->is_updated);
    }

    /** @test */
    public function is_not_marked_if_updated_before_the_day_of_publishing(): void
    {
        $project = Project::factory()->published()->state([
            'publish_at' => Carbon::createFromFormat('d-m-Y', '10-10-2019'),
            'updated_at' => Carbon::createFromFormat('d-m-Y', '10-10-2017'),
        ])->create();

        $this->assertFalse($project->is_updated);
    }
}

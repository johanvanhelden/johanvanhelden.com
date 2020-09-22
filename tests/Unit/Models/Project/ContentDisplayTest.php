<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Project;

use App\Models\Project;
use Tests\TestCase;

class ContentDisplayTest extends TestCase
{
    /** @test */
    public function markdown_is_converted_to_html(): void
    {
        $project = Project::factory()->published()->create([
            'content' => '# Hi there!',
        ]);

        $this->assertEquals('<h1>Hi there!</h1>', trim($project->content_display));
    }
}

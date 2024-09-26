<?php

declare(strict_types=1);

namespace Tests\Unit\Data\Project;

use App\Data\Project;
use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ContentDisplayTest extends TestCase
{
    #[Test]
    public function markdown_is_converted_to_html(): void
    {
        File::partialMock()
            ->shouldReceive('get')
            ->with(resource_path('data/projects.json'))
            ->andReturn(json_encode([
                [
                    'slug'    => 'test',
                    'content' => '# Hi there!',

                    'publish_at' => null,
                    'created_at' => null,
                    'updated_at' => null,
                ],
            ]));

        // Now, when calling Project::bySlug('test'), it will use the mocked 'all' method
        $project = Project::bySlug('test');

        $this->assertEquals('<h1>Hi there!</h1>', trim($project['content_display']));
    }
}

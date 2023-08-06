<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Data\Project;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function show(string $slug): View
    {
        $project = Project::bySlug($slug);

        if (!$project['is_public']) {
            abort(403);
        }

        return view('project.show', [
            'project' => $project,
        ]);
    }
}

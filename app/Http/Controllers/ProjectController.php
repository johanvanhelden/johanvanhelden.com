<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Data\Project;
use Illuminate\Support\ItemNotFoundException;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function show(string $slug): View
    {
        try {
            $project = Project::bySlug($slug);
        } catch (ItemNotFoundException) {
            abort(404);
        }

        if (!$project['is_public']) {
            abort(403);
        }

        return view('project.show', [
            'project' => $project,
        ]);
    }
}

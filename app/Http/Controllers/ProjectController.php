<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function show(Project $project): Response
    {
        $this->authorize('view', $project);

        return Inertia::render('Project/Show', [
            'project' => new ProjectResource($project),
        ]);
    }
}

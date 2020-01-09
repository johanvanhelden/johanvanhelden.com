<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Inertia\Inertia;

/**
 * The project controller.
 */
class ProjectController extends Controller
{
    /**
     * Renders the project's show page.
     *
     * @param Project $project
     *
     * @return \Inertia\Response
     */
    public function show(Project $project)
    {
        $this->authorize('view', $project);

        ProjectResource::withoutWrapping();

        return Inertia::render('Project/Show', [
            'project' => new ProjectResource($project),
        ]);
    }
}

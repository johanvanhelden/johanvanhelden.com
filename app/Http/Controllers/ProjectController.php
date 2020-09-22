<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function show(Project $project): View
    {
        $this->authorize('view', $project);

        return view('project.show', [
            'project' => $project,
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Http\Resources\ToolResource;
use App\Models\Project;
use App\Models\Tool;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class PagesController extends Controller
{
    public function home(): Response
    {
        $projects = Project::published()->latestPublished()->get();
        $tools = Tool::published()->ordered()->get();

        return Inertia::render('Home', [
            'expandedHeader' => true,
            'projects'       => ProjectResource::collection($projects),
            'tools'          => ToolResource::collection($tools),
            'subscription'   => Session::get('subscription'),
            'unsubscribed'   => Session::get('unsubscribed'),
        ]);
    }
}

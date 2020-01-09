<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Http\Resources\ToolResource;
use App\Models\Project;
use App\Models\Tool;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

/**
 * The pages controller.
 */
class PagesController extends Controller
{
    /**
     * Renders the homepage.
     *
     * @return \Inertia\Response
     */
    public function home()
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

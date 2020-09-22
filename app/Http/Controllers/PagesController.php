<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Tool;
use Illuminate\View\View;

class PagesController extends Controller
{
    public function home(): View
    {
        return view('page.home', [
            'projects' => Project::published()->latestPublished()->get(),
            'tools'    => Tool::published()->ordered()->get(),
        ]);
    }
}

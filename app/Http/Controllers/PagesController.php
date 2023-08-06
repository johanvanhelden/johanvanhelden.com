<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Data\Project;
use App\Data\Tool;
use Illuminate\View\View;

class PagesController extends Controller
{
    public function home(): View
    {
        return view('page.home', [
            'projects' => Project::public(),
            'tools'    => Tool::public(),
        ]);
    }
}

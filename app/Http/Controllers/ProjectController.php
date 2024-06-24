<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function store(Request $request, int $projectId): RedirectResponse
    {
        Project::create($request->all());

        return redirect()->route('tasks.index', ['project_id' => $projectId]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request): View
    {
        $projects = Project::all();
        $projectId = $request->get('project_id', $projects->first()?->id);

        if ($projectId) {
            $tasks = Task::where('project_id', $projectId)
                ->orderBy('priority', 'asc')
                ->get();
        } else {
            $tasks = collect();
        }

        return view('tasks', compact('projects', 'tasks', 'projectId'));
    }

    public function store(Request $request, int $projectId): RedirectResponse
    {
        $request['project_id'] = $projectId;
        Task::create($request?->all());

        return redirect()->route('tasks.index', ['project_id' => $projectId]);
    }

    public function edit($projectId, $taskId): View
    {
        $task = Task::find($taskId);

        return view('editTask', compact('projectId', 'task'));
    }

    public function update(Request $request, int $projectId, int $taskId): RedirectResponse
    {
        $task = Task::find($taskId);
        $task->updateOrFail($request->all());

        return redirect()->route('tasks.index', ['project_id' => $projectId]);
    }

    public function destroy($projectId, int $taskId): RedirectResponse
    {
        $task = Task::find($taskId);
        $task->deleteOrFail();

        return redirect()->route('tasks.index', ['project_id' => $projectId]);
    }

    public function reorder(Request $request): JsonResponse
    {
        $priority = $request->input('priority');

        foreach ($priority as $item) {
            $task = Task::find($item['id']);
            if ($task) {
                $task->priority = $item['priority'];
                $task->save();
            }
        }

        return response()->json(['success' => true]);
    }
}

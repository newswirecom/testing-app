<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatusEnum;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Resources\TaskDetailsResource;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{

    /**
     * Display the list of tasks
     */
    public function show(Request $request): Response
    {
        return Inertia::render('Dashboard/Index', [
            'tasks' => TaskDetailsResource::collection(Task::with("user")->get())->toArray($request),
        ]);
    }

    /**
     * create the task.
     */
    public function create(TaskUpdateRequest $request): RedirectResponse
    {
        Task::create($request->validated());
        return Redirect::route('dashboard');
    }

    /**
     * Update the task status to `in progress` and attribute it to the user.
     */
    public function takeOn(Request $request, Task $task): RedirectResponse
    {
        $task->user_id = $request->user()->id;
        $task->status = TaskStatusEnum::IN_PROGRESS;
        $task->save();

        return Redirect::route('dashboard');
    }

    /**
     * Update the task information.
     */
    public function update(TaskUpdateRequest $request, Task $task): RedirectResponse
    {
        $task->update($request->validated());
        return Redirect::route('dashboard');
    }

    /**
     * Delete the task
     */
    public function destroy(Request $request, Task $task): RedirectResponse
    {
        $task->delete();
        return Redirect::route('dashboard');
    }
}

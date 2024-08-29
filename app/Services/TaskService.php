<?php

namespace App\Services;

use Exception;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\TaskRequest;

class TaskService
{
    public function list()
    {
        try {
            return Task::with('project')->get();
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    public function show(Task $task): Task
    {
        try {
            return $task;
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    public function store(TaskRequest $request)
    {
        try {
            $task = Task::create($request->validated());

            $project = $task->project;
            if ($project) {
                $project->touch();
            }

            return $task;
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    public function update(TaskRequest $request, Task $task)
    {
        try {
            $task->update($request->validated());

            if ($task->project_id) {
                $project = Project::find($task->project_id);
                if ($project) {
                    $project->touch();
                }
            }

            return $task;
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    public function destroy(Task $task)
    {
        try {
            $task->delete();
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }
}

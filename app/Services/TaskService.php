<?php

namespace App\Services;

use Exception;
use App\Models\Task;
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
            return Task::create($request->validated());
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    public function update(TaskRequest $request, Task $task)
    {
        try {
            return tap($task)->update($request->validated());
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

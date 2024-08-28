<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Services\TaskService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use App\Http\Requests\TaskRequest;
use App\Models\Task;

class TaskController extends Controller
{
    public function __construct(private TaskService $taskService)
    {
    }

    public function index()
    {
        try {
            $tasks = $this->taskService->list();
            return TaskResource::collection($tasks);
        } catch (Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function store(TaskRequest $request)
    {
        try {
            $task = $this->taskService->store($request);
            return new TaskResource($task);
        } catch (Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function show(Task $task)
    {
        try {
            $task = $this->taskService->show($task);
            return new TaskResource($task);
        } catch (Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function update(TaskRequest $request, Task $task)
    {
        try {
            $task = $this->taskService->update($request, $task);
            return new TaskResource($task);
        } catch (Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function destroy(Task $task)
    {
        try {
            $this->taskService->destroy($task);
            return response()->json([], 202);
        } catch (Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}

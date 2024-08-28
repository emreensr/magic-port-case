<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Services\ProjectService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ProjectResource;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;

class ProjectController extends Controller
{
    public function __construct(private ProjectService $projectService)
    {
    }

    public function index()
    {
        try {
            $projects = $this->projectService->list();

            return ProjectResource::collection($projects);
        } catch (Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function store(ProjectRequest $request)
    {
        try {
            $project = $this->projectService->store($request);
            return new ProjectResource($project);
        } catch (Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function show(Project $project)
    {
        try {
            $project = $this->projectService->show($project);
            return new ProjectResource($project);
        } catch (Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function update(ProjectRequest $request, Project $project)
    {
        try {
            $project = $this->projectService->update($request, $project);
            return new ProjectResource($project);
        } catch (Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function destroy(Project $project)
    {
        try {
            $this->projectService->destroy($project);
            return response()->json([], 202);
        } catch (Exception $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}

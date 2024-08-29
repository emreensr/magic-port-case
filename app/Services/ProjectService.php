<?php

namespace App\Services;

use Exception;
use App\Models\Project;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProjectRequest;

class ProjectService
{
    public function list()
    {
        try {
            return Project::with('tasks')->latest()->get();
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    public function show(Project $project): Project
    {
        try {
            return $project;
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    public function store(ProjectRequest $request)
    {
        try {
            return Project::create($request->validated());
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    public function update(ProjectRequest $request, Project $project)
    {
        try {
            return tap($project)->update($request->validated());
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    public function destroy(Project $project)
    {
        try {
            $project->delete();
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }
}

<?php

namespace App\Http\Controllers\FrontEnd;

use Exception;
use App\Services\ProjectService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ProjectResource;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;

class FrontProjectController extends Controller
{

    public function index()
    {
        return view('dashboard');
    }
    public function show(Project $project)
    {
        return view('projectDetail', [
            'project' => $project
        ]);
    }

}

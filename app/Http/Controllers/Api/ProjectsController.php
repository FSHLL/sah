<?php

namespace App\Http\Controllers\Api;

use App\Actions\Credential\StoreOrUpdateProject;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response;

class ProjectsController extends Controller
{
    public function index(): JsonResponse
    {
        return Response::json(
            Project::where('user_id', auth()->id())->paginate()
        );
    }

    public function store(StoreProjectRequest $request, StoreOrUpdateProject $storeOrUpdateProject): JsonResponse
    {
        return Response::json(
            $storeOrUpdateProject->handle($request),
            HttpResponse::HTTP_CREATED
        );
    }

    public function show(Project $project): JsonResponse
    {
        return Response::json($project);
    }

    public function update(UpdateProjectRequest $request, Project $project, StoreOrUpdateProject $storeOrUpdateProject): JsonResponse
    {
        return Response::json($storeOrUpdateProject->handle($request, $project));
    }

    public function destroy(Project $project): JsonResponse
    {
        return Response::json($project->delete());
    }
}

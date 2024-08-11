<?php

namespace App\Http\Controllers\Api;

use App\Factories\StackServiceFactory;
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

    public function store(StoreProjectRequest $request)
    {
        return Response::json(
            Project::create([
                ...$request->validated(),
                'user_id' => auth()->user()->getAuthIdentifier(),
            ]),
            HttpResponse::HTTP_CREATED
        );
    }

    public function show(Project $project): JsonResponse
    {
        return Response::json($project);
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->validated());
        return Response::json(
            $project->fresh()
        );
    }

    public function destroy(Project $project): JsonResponse
    {
        return Response::json($project->delete());
    }

    public function stack(Project $project): JsonResponse
    {
        $stackService = StackServiceFactory::create($project->credential->type->value);
        return Response::json($stackService->getProjectStackInfo($project));
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Actions\Project\StoreOrUpdateProject;
use App\Actions\Project\UpdateVersions;
use App\Factories\FunctionServiceFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Requests\Project\UpdateVersionsRequest;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
        $project->deployments()->delete();

        return Response::json($project->delete());
    }

    public function aliasVersion(Project $project, Request $request): JsonResponse
    {
        $functionService = FunctionServiceFactory::create($project->credential->type->value);

        return Response::json(
            $functionService->getAliasVersion($project->credential, $request->input('function'), $project->alias)
        );
    }

    public function versions(Project $project): JsonResponse
    {
        $functionService = FunctionServiceFactory::create($project->credential->type->value);

        return Response::json($functionService->listVersionsByFunction($project->credential, $project->stack_resources->getFunctions()));
    }

    public function updateVersions(Project $project, UpdateVersionsRequest $request, UpdateVersions $updateVersions): JsonResponse
    {
        return Response::json($updateVersions->handle($request, $project));
    }
}

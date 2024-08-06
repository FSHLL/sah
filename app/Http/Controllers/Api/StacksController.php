<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\StackService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class StacksController extends Controller
{
    public function index(StackService $stackService): JsonResponse
    {
        return Response::json(
            $stackService->getStacks(auth()->user()->awsCredential)->get('StackSummaries')
        );
    }

    public function project(Project $project, StackService $stackService): JsonResponse
    {
        return Response::json($stackService->getProjectStackInfo($project));
    }
}

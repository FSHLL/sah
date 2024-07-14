<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\StackService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class StackController extends Controller
{
    public function index(StackService $stackService): JsonResponse
    {
        return Response::json(
            $stackService->getStack(auth()->user()->awsCredential)->get('StackSummaries')
        );
    }
}

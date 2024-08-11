<?php

namespace App\Http\Controllers\Api;

use App\Factories\StackServiceFactory;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class StacksController extends Controller
{
    public function index(): JsonResponse
    {
        $stackService = StackServiceFactory::create(auth()->user()->credential->type->value);
        return Response::json(
            $stackService->getStacks(auth()->user()->credential)
        );
    }
}

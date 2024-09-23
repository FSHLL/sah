<?php

use App\Http\Controllers\Api\CredentialsController;
use App\Http\Controllers\Api\ProjectDeploymentsController;
use App\Http\Controllers\Api\ProjectsController;
use App\Http\Controllers\Api\StacksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('credentials', CredentialsController::class)->middleware('auth:sanctum');
Route::apiResource('projects', ProjectsController::class)->middleware('auth:sanctum');
Route::get('projects/{project}/aliasVersion', [ProjectsController::class, 'aliasVersion'])->middleware('auth:sanctum');
Route::apiResource('stacks', StacksController::class)->middleware('auth:sanctum')->only('index');
Route::apiResource('projects.deployments', ProjectDeploymentsController::class)->middleware('auth:sanctum')->only(['index', 'store', 'show']);
Route::put('projects/{project}/deployments/{deployment}/rollback', [ProjectDeploymentsController::class, 'rollback'])->middleware('auth:sanctum');

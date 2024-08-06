<?php

use App\Http\Controllers\Api\ProjectsController;
use App\Http\Controllers\Api\StacksController;
use App\Http\Controllers\Api\CredentialsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('projects', ProjectsController::class)->middleware('auth:sanctum');
Route::apiResource('stacks', StacksController::class)->middleware('auth:sanctum')->only('index');
Route::get('stacks/project/{project}', [StacksController::class, 'project'])->middleware('auth:sanctum');
Route::apiResource('credentials', CredentialsController::class)->middleware('auth:sanctum');

<?php

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\StackController;
use App\Http\Controllers\Api\CredentialsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('projects', ProjectController::class)->middleware('auth:sanctum');
Route::apiResource('stacks', StackController::class)->middleware('auth:sanctum')->only('index');
Route::get('stacks/project/{project}', [StackController::class, 'project'])->middleware('auth:sanctum');
Route::apiResource('credentials', CredentialsController::class)->middleware('auth:sanctum');

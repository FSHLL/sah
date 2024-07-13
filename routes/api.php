<?php

use App\Http\Controllers\Api\AWSCredentialController;
use App\Http\Controllers\Api\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('aws-credentials', AWSCredentialController::class)->middleware('auth:sanctum');
Route::apiResource('projects', ProjectController::class)->middleware('auth:sanctum');

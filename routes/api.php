<?php

use App\Http\Controllers\Api\AWSCredentialController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('aws-credential', AWSCredentialController::class)->middleware('auth:sanctum');

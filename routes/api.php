<?php

use App\Http\Controllers\Api\CredentialsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('credentials', CredentialsController::class)->middleware('auth:sanctum');

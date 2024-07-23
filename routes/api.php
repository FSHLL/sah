<?php

use App\Http\Controllers\Api\CredentialController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('credentials',CredentialController::class)->middleware('auth:sanctum');

<?php

namespace App\Providers;

use App\Models\AWSCredential;
use App\Models\Project;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Route::modelAuth('aws_credential', AWSCredential::class);
        Route::modelAuth('project', Project::class);
    }
}

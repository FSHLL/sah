<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\Credential;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Route::modelAuth('credential', Credential::class);
        Route::modelAuth('project', Project::class);
    }
}

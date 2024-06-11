<?php

namespace App\Providers;

use App\Models\AWSCredential;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Route::modelAuth('aws_credential', AWSCredential::class);
    }
}

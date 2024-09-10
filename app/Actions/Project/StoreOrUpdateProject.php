<?php

namespace App\Actions\Project;

use App\Factories\StackResourcesFactory;
use App\Factories\StackServiceFactory;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;

class StoreOrUpdateProject
{
    public function handle(StoreProjectRequest|UpdateProjectRequest $request, ?Project $project = null): Project
    {
        $project = $project ?? new Project;

        $project->name = $request->input('name');
        $project->stack_id = $request->input('stack_id');
        $project->credential_id = auth()->user()->credential->id;
        $project->user_id = auth()->id();

        $stackService = StackServiceFactory::create($project->credential->type->value);

        $project->stack_resources = StackResourcesFactory::create(
            $project->credential->type->value,
            $stackService->getStack($project->credential, $project->stack_id)->toArray()
        );

        $project->save();

        return $project;
    }
}

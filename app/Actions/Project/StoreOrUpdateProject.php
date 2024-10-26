<?php

namespace App\Actions\Project;

use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Jobs\UpdateStackResourcesInfo;
use App\Models\Project;

class StoreOrUpdateProject
{
    public function handle(StoreProjectRequest|UpdateProjectRequest $request, ?Project $project = null): Project
    {
        $project = $project ?? new Project;

        $project->name = $request->input('name');
        $project->stack_id = $request->input('stack_id');
        $project->alias = $request->input('alias');
        $project->credential_id = auth()->user()->credential->id;
        $project->user_id = auth()->id();

        $project->save();

        UpdateStackResourcesInfo::dispatch($project);

        return $project;
    }
}

<?php

namespace App\Actions\Project;

use App\Factories\FunctionServiceFactory;
use App\Http\Requests\Project\UpdateVersionsRequest;
use App\Models\Project;

class UpdateVersions
{
    public function handle(UpdateVersionsRequest $request, Project $project): bool
    {
        $functionService = FunctionServiceFactory::create($project->credential->type->value);

        foreach ($request->input('functions') as $function => $version) {
            $functionService->updateAlias($project->credential, $function, 'ACTIVE', $version);
        }

        return true;
    }
}

<?php

namespace App\Actions\Deployment;

use App\Factories\StackResourcesFactory;
use App\Factories\StackServiceFactory;
use App\Models\Deployment;
use App\Models\Project;

class StoreDeploymentAction
{
    public function handle(?Project $project = null): Deployment
    {
        $deploy = new Deployment;

        $stackService = StackServiceFactory::create($project->credential->type->value);

        $deploy->project_id = $project->id;

        $stack_resources = StackResourcesFactory::create(
            $project->credential->type->value,
            $stackService->getStack($project->credential, $project->stack_id)->toArray()
        );

        $project->stack_resources = $stack_resources;
        $deploy->stack_resources = json_encode($stack_resources->getStack());

        $project->save();
        $deploy->save();

        return $deploy;
    }
}

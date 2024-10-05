<?php

namespace App\Actions\Deployment;

use App\Factories\FunctionServiceFactory;
use App\Factories\StackResourcesFactory;
use App\Models\Deployment;
use Illuminate\Support\Str;

class RollbackDeploymentAction
{
    public function handle(Deployment $deployment)
    {
        $stack = StackResourcesFactory::create($deployment->project->credential->type->value, json_decode($deployment->stack_resources, true));
        $functionService = FunctionServiceFactory::create($deployment->project->credential->type->value);

        $versions = $stack->getVersions();

        foreach ($stack->getFunctions() as $index => $function) {
            $functionService->updateAlias(
                $deployment->project->credential,
                $function,
                'ACTIVE',
                Str::afterLast($versions[$index], ':')
            );
        }

        return true;
    }
}

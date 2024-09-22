<?php

namespace App\CloudServices\AWS;

use App\Contracts\CloudServices\FunctionServiceContract;
use App\Models\Credential;
use App\Models\Project;
use Aws\Result;
use Aws\Sdk;
use JmesPath\Env as JmesPath;

class FunctionService implements FunctionServiceContract
{
    public function listAliases(Credential $credential, string $function): Result
    {
        $client = (new Sdk($credential->settings->getSettings()))->createLambda();

        return $client->listAliases(['FunctionName' => $function]);
    }

    public function createAlias(Credential $credential, string $function, string $alias, string $version): Result
    {
        $client = (new Sdk($credential->settings->getSettings()))->createLambda();

        return $client->createAlias([
            'FunctionName' => $function,
            'Name' => $alias,
            'version' => $version,
        ]);
    }

    public function updateAlias(Credential $credential, string $function, string $alias, string $version): Result
    {
        $client = (new Sdk($credential->settings->getSettings()))->createLambda();

        return $client->updateAlias([
            'FunctionName' => $function,
            'Name' => $alias,
            'version' => $version,
        ]);
    }

    public function getTriggers(Credential $credential, string $function, ?string $qualifier = null): Result
    {
        $client = (new Sdk($credential->settings->getSettings()))->createLambda();

        $args = ['FunctionName' => $function];

        $args = ! $qualifier ? $args : array_merge($args, ['Qualifier' => $qualifier]);

        return $client->getPolicy($args);
    }

    public function listAliasesFromProject(Project $project): array
    {
        $lambdas = JmesPath::search("StackResourceSummaries[?ResourceType == 'AWS::Lambda::Function'].PhysicalResourceId", $project->stack_resources);
        $aliases = [];

        foreach ($lambdas as $lambda) {
            $aliases[$lambda] = $this->listAliases($project->credential, $lambda)->get('Aliases');
        }

        return $aliases;
    }
}

<?php

namespace App\CloudServices\AWS;

use App\Contracts\CloudServices\StackServiceContract;
use App\Models\Credential;
use App\Models\Project;
use Aws\Result;
use Aws\Sdk;

class StackService implements StackServiceContract
{
    public function getStacks(Credential $credential): Result
    {
        $client = (new Sdk($credential->settings->getSettings()))->createCloudFormation();

        return $client->listStacks();
    }

    public function getStack(Credential $credential, string $stackId): Result
    {
        $client = (new Sdk($credential->settings->getSettings()))->createCloudFormation();

        return $client->describeStacks(['StackName' => $stackId]);
    }

    public function getProjectStackInfo(Project $project): array
    {
        $stack = $this->getStack($project->credential, $project->stack_id);

        $lambdas = $stack->search("Stacks[].Outputs[?contains(OutputKey, 'LambdaFunctionQualifiedArn')]");

        return [
            'stack' => $stack->search('Stacks'),
            'lambdas' => $lambdas,
        ];
    }
}

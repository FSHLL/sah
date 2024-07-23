<?php

namespace App\Services;

use App\Models\AWSCredential;
use App\Models\Project;
use Aws\Result;
use Aws\Sdk;

class StackService
{
    public function getStacks(AWSCredential $aWSCredential): Result
    {
        $client = (new Sdk($aWSCredential->getConfig()))->createCloudFormation();

        return $client->listStacks();
    }

    public function getStack(AWSCredential $aWSCredential, string $stack): Result
    {
        $client = (new Sdk($aWSCredential->getConfig()))->createCloudFormation();

        return $client->describeStacks(['StackName' => $stack]);
    }

    public function getProjectStackInfo(Project $project): array
    {
        $stack = $this->getStack($project->awsCredential, $project->stack_id);

        $lambdas = $stack->search("Stacks[].Outputs[?contains(OutputKey, 'LambdaFunctionQualifiedArn')]");

        return [
            ...$stack,
            'lambdas' => $lambdas,
        ];
    }
}

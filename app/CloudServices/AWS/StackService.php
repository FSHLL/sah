<?php

namespace App\CloudServices\AWS;

use App\Contracts\CloudServices\StackServiceContract;
use App\Models\Credential;
use Aws\Result;
use Aws\Sdk;

class StackService implements StackServiceContract
{
    public function getStacks(Credential $credential): array
    {
        $client = (new Sdk($credential->settings->getSettings()))->createCloudFormation();

        return $client->listStacks()->get('StackSummaries');
    }

    public function getStack(Credential $credential, string $stackId): Result
    {
        $client = (new Sdk($credential->settings->getSettings()))->createCloudFormation();

        return $client->listStackResources(['StackName' => $stackId]);
    }
}

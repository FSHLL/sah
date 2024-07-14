<?php

namespace App\Services;

use App\Models\AWSCredential;
use Aws\Result;
use Aws\Sdk;

class StackService
{
    public function getStack(AWSCredential $aWSCredential): Result
    {
        $client = (new Sdk($aWSCredential->getConfig()))->createCloudFormation();

        return $client->listStacks();
    }
}

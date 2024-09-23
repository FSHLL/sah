<?php

namespace App\CloudServices\AWS;

use App\Contracts\CloudServices\FunctionServiceContract;
use App\Models\Credential;
use Aws\Result;
use Aws\Sdk;

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
            'Name' => $alias,
            'FunctionName' => $function,
            'FunctionVersion' => $version,
        ]);
    }

    public function getTriggers(Credential $credential, string $function, ?string $qualifier = null): Result
    {
        $client = (new Sdk($credential->settings->getSettings()))->createLambda();

        $args = ['FunctionName' => $function];

        $args = ! $qualifier ? $args : array_merge($args, ['Qualifier' => $qualifier]);

        return $client->getPolicy($args);
    }

    public function getAliasVersion(Credential $credential, string $function, string $alias): string
    {
        $client = (new Sdk($credential->settings->getSettings()))->createLambda();

        return $client->getAlias([
            'Name' => $alias,
            'FunctionName' => $function,
        ])->get('FunctionVersion');
    }
}

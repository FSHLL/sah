<?php

namespace App\Contracts\CloudServices;

use App\Models\Credential;

interface FunctionServiceContract
{
    public function listAliases(Credential $credential, string $function);

    public function createAlias(Credential $credential, string $function, string $alias, string $version);

    public function updateAlias(Credential $credential, string $function, string $alias, string $version);

    public function getTriggers(Credential $credential, string $function, ?string $qualifier = null);

    public function getAliasVersion(Credential $credential, string $function, string $alias);
}

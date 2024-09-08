<?php

namespace App\Stacks;

use Illuminate\Support\Str;
use JmesPath\Env as JmesPath;

class AWSStack extends StackBase
{
    public function getFunctions(): array
    {
        return JmesPath::search("StackResourceSummaries[?ResourceType == 'AWS::Lambda::Function'].PhysicalResourceId", $this->stack);
    }

    public function getAliases(): array
    {
        return JmesPath::search("StackResourceSummaries[?ResourceType == 'AWS::Lambda::Alias'].PhysicalResourceId", $this->stack);
    }

    public function getVersion(): array
    {
        return JmesPath::search("StackResourceSummaries[?ResourceType == 'AWS::Lambda::Version'].PhysicalResourceId", $this->stack);
    }

    public function aliasSync(): bool
    {
        $aliases = array_map(fn ($alias) => Str::afterLast($alias, ':'), $this->getAliases());

        return count(array_unique($aliases)) === 1;
    }
}

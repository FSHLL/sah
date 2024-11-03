<?php

namespace App\Stacks;

use Illuminate\Contracts\Support\Arrayable;

abstract class StackBase implements Arrayable
{
    public function __construct(protected ?array $stack)
    {
        //
    }

    abstract public function getFunctions(): array;

    abstract public function getAliases(): array;

    abstract public function getVersions(): array;

    abstract public function getTriggers(): array;

    abstract public function aliasSync(): bool;

    public function getStack(): ?array
    {
        return $this->stack;
    }

    public function groupStackInfo()
    {
        $groupedInfo = [];

        $aliases = $this->getAliases();
        $versions = $this->getVersions();
        $triggers = $this->getTriggers();

        foreach ($this->getFunctions() as $index => $funcName) {

            $alias = $aliases[$index] ?? '';
            $version = $versions[$index];

            $tri = array_filter($triggers, fn ($trigger) => $trigger['function'] === $alias || str_contains($trigger['function'], $funcName));

            $groupedInfo[] = [
                'function' => $funcName,
                'alias' => $alias,
                'version' => $version,
                'triggers' => array_values($tri),
            ];
        }

        return $groupedInfo;
    }

    public function toArray(): array
    {
        return $this->stack ? [
            'functions' => $this->groupStackInfo(),
            'alias_sync' => $this->aliasSync(),
        ] : [];
    }
}

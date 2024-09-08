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

    abstract public function getVersion(): array;

    abstract public function aliasSync(): bool;

    public function getStack(): ?array
    {
        return $this->stack;
    }

    public function toArray(): array
    {
        return [
            'functions' => $this->getFunctions(),
            'aliases' => $this->getAliases(),
            'versions' => $this->getVersion(),
            'alias_sync' => $this->aliasSync(),
        ];
    }
}

<?php

namespace App\Factories;

use App\Enums\CredentialType;
use App\Stacks\AWSStack;
use App\Stacks\StackBase;

class StackResourcesFactory
{
    public static function create(string $type, ?array $stack): StackBase
    {
        return match ($type) {
            CredentialType::AWS->value => new AWSStack($stack),
            default => throw new \InvalidArgumentException('Invalid stack type'),
        };
    }
}

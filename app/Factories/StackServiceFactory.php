<?php

namespace App\Factories;

use App\CloudServices\AWS\StackService;
use App\Contracts\CloudServices\StackServiceContract;
use App\Enums\CredentialType;

class StackServiceFactory
{
    public static function create(string $type): StackServiceContract
    {
        return match ($type) {
            CredentialType::AWS->value => new StackService(),
            default => throw new \InvalidArgumentException('Invalid service'),
        };
    }
}

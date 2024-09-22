<?php

namespace App\Factories;

use App\CloudServices\AWS\FunctionService;
use App\Contracts\CloudServices\FunctionServiceContract;
use App\Enums\CredentialType;

class FunctionServiceFactory
{
    public static function create(string $type): FunctionServiceContract
    {
        return match ($type) {
            CredentialType::AWS->value => new FunctionService,
            default => throw new \InvalidArgumentException('Invalid service'),
        };
    }
}

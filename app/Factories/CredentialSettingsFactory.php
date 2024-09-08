<?php

namespace App\Factories;

use App\Enums\CredentialType;
use App\Settings\Credentials\AWSCredentialSettings;
use App\Settings\Credentials\CredentialSettings;

class CredentialSettingsFactory
{
    public static function create(string $type): CredentialSettings
    {
        return match ($type) {
            CredentialType::AWS->value => new AWSCredentialSettings,
            default => throw new \InvalidArgumentException('Invalid credential type'),
        };
    }
}

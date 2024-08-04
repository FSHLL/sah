<?php

namespace App\Settings\Credentials;

use Illuminate\Support\Arr;

class AWSCredentialSettings extends CredentialSettings
{
    public function mapSettings(array $settings): array
    {
        return [
            'credentials' => [
                'key' => Arr::get($settings, 'access_key_id'),
                'secret' => Arr::get($settings, 'access_key_secret'),
            ],
            'region' => Arr::get($settings, 'region', 'us-east-1'),
        ];
    }

    public function getRules(): array
    {
        return [
            'access_key_id' => ['string', 'max:120'],
            'access_key_secret' => ['string', 'max:120'],
            'region' => ['string', 'max:120'],
        ];
    }
}

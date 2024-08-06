<?php

namespace App\Casts;

use App\Factories\CredentialSettingsFactory;
use App\Settings\Credentials\CredentialSettings as CredentialSettingsObject;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class CredentialSettings implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return CredentialSettingsFactory::create($attributes['type'])->setSettings($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (! $value instanceof CredentialSettingsObject) {
            throw new InvalidArgumentException('The given value is not an Settings instance.');
        }

        return $value->encryptSettings();
    }
}

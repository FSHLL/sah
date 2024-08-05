<?php

namespace App\Settings\Credentials;

abstract class CredentialSettings
{
    public function __construct(private array|string|null $settings = null)
    {
        //
    }

    public function setSettings(array|string|null $settings = null): self
    {
        $this->settings = $settings;

        return $this;
    }

    public function getSettings(): array
    {
        return is_string($this->settings)
            ? $this->mapSettings(decrypt($this->settings))
            : $this->settings;
    }

    public function encryptSettings(): string
    {
        return is_string($this->settings)
            ? $this->settings
            : encrypt($this->settings);
    }

    abstract public function mapSettings(array $settings): array;

    abstract public function getRules(): array;
}

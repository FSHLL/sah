<?php

namespace App\Actions\Credential;

use App\Enums\CredentialType;
use App\Factories\CredentialSettingsFactory;
use App\Http\Requests\Credential\StoreCredentialRequest;
use App\Http\Requests\Credential\UpdateCredentialRequest;
use App\Models\Credential;

class StoreOrUpdateCredential
{
    public function handle(StoreCredentialRequest|UpdateCredentialRequest $request, ?Credential $credential = null): Credential
    {
        $type = $request->input('type', CredentialType::AWS->value);

        $credentialSettings = CredentialSettingsFactory::create($type);

        $credentialSettings->setSettings($request->validated());

        $credential = $credential ?? new Credential;

        $credential->type = $type;
        $credential->settings = $credentialSettings;
        $credential->user_id = auth()->id();

        $credential->save();

        return $credential;
    }
}

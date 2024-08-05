<?php

namespace App\Http\Requests\Credential;

use App\Enums\CredentialType;
use App\Factories\CredentialSettingsFactory;
use Illuminate\Foundation\Http\FormRequest;

class StoreCredentialRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = CredentialSettingsFactory::create($this->input('type', CredentialType::AWS->value))->getRules();

        return array_map(fn (array $rul) => ['required', ...$rul], $rules);
    }
}

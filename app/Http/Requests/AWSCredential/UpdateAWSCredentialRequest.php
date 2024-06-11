<?php

namespace App\Http\Requests\AWSCredential;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAWSCredentialRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'access_key_id' => ['required', 'string', 'max:120'],
            'access_key_secret' => ['required', 'string', 'max:120'],
        ];
    }
}

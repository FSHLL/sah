<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'stack_id' => ['string'],
            'a_w_s_credential_id' => ['uuid', 'exists:a_w_s_credentials,id']
        ];
    }
}

<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'stack_id' => ['required', 'string', 'unique:projects'],
            'a_w_s_credential_id' => ['required', 'uuid', 'exists:a_w_s_credentials,id']
        ];
    }
}

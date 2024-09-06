<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'stack_id' => ['required', 'string', 'unique:projects,stack_id'],
            'credential_id' => ['required', 'uuid', 'exists:credentials,id'],
        ];
    }
}

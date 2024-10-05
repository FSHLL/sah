<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVersionsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'functions' => ['required', 'array'],
            // 'functions.*' => [Rule::in($this->project->stack_resources->getFunctions())]
        ];
    }
}

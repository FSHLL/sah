<?php

namespace App\Http\Requests\Token;

use Illuminate\Foundation\Http\FormRequest;

class StoreTokenRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'min:1'],
        ];
    }
}

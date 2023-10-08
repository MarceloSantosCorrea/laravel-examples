<?php

namespace App\Http\Requests\Api\Todo;

use Illuminate\Foundation\Http\FormRequest;

class StoreTodoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            /** @example Trabalhar,estudar */
            'body' => ['required', 'string'],
            /** @example false */
            'checked' => ['nullable', 'boolean'],
        ];
    }
}

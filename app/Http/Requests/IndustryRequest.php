<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndustryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $industryId = $this->route('industry')?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'options' => ['required', 'array', 'min:1'],
            'options.*.id' => ['nullable', 'integer', 'exists:industry_options,id'],
            'options.*.name' => ['required', 'string', 'max:255'],
            'image' => [
                $industryId ? 'nullable' : 'required',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:3000',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'options.required' => 'At least one option is required.',
            'options.min' => 'At least one option is required.',
            'options.*.name.required' => 'Option name is required.',
        ];
    }
}

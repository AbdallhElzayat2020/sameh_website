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
        return [];
    }
}

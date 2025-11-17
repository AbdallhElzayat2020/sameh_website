<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IosImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'title' => ['required', 'string', 'max:255'],
        ];

        if ($this->isMethod('post')) {
            $rules['image'] = ['required', 'image', 'max:5120'];
        } else {
            $rules['image'] = ['nullable', 'image', 'max:5120'];
        }

        return $rules;
    }
}

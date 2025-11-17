<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePriceRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'project_name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:3'],
            'time_zone' => ['required', 'string'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'end_time' => ['required', 'date_format:H:i'],
            'preferred_payment_type' => ['required', 'string'],
            'source_language' => ['required', 'string'],
            'target_language' => ['required', 'string', 'different:source_language'],
            'currency' => ['required', 'string'],
            'services' => ['nullable', 'array'],
            'services.*' => ['sometimes', 'string', 'max:255'],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => [
                'file',
                'max:20480',
                'mimetypes:image/jpeg,image/png,image/gif,image/webp,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,text/plain,application/zip,application/x-zip-compressed',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'services.required' => 'Please select at least one service.',
            'attachments.*.max' => 'Each file must not exceed 20MB.',
        ];
    }
}

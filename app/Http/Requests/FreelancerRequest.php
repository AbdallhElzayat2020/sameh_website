<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FreelancerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $freelancerId = $this->route('freelancer')?->id;

        return [
            'freelancer_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('freelancers', 'freelancer_code')->ignore($freelancerId),
            ],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('freelancers', 'email')->ignore($freelancerId)],
            'phone' => ['required', 'string', 'max:30', Rule::unique('freelancers', 'phone')->ignore($freelancerId)],
            'quota' => ['required', 'string', 'max:255'],
            'price_hr' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'max:10'],
            'languages' => ['required', 'array', 'min:1'],
            'languages.*.source' => ['required', 'string', 'max:100'],
            'languages.*.target' => ['required', 'string', 'max:100'],
            'service_ids' => ['nullable', 'array'],
            'service_ids.*' => ['exists:services,id'],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => [
                'file',
                'max:20480',
                'mimetypes:image/jpeg,image/png,image/gif,image/webp,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/zip,application/x-zip-compressed,text/plain',
            ],
        ];
    }
}

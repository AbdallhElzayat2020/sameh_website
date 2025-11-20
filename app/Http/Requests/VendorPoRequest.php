<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorPoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'freelancer_code' => ['required', 'string', 'max:255', 'exists:freelancers,freelancer_code'],
            'project_name' => ['required', 'string', 'max:255'],
            'page_number' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'start_date' => ['required', 'date'],
            'payment_date' => ['required', 'date', 'after_or_equal:start_date'],
            'service_ids' => ['nullable', 'array'],
            'service_ids.*' => ['integer', 'exists:services,id'],
            'note' => ['nullable', 'string'],
            'po_file' => ['required', 'file', 'mimes:pdf', 'max:20480'],
        ];
    }
}

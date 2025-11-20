<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientPoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_code' => ['required', 'string', 'max:255', 'exists:clients,client_code'],
            'date_20' => ['required', 'date'],
            'date_80' => ['required', 'date', 'after_or_equal:date_20'],
            'payment_20' => ['required', 'numeric', 'min:0'],
            'payment_80' => ['required', 'numeric', 'min:0'],
            'total_price' => ['required', 'numeric', 'min:0'],
            'service_ids' => ['nullable', 'array'],
            'service_ids.*' => ['integer', 'exists:services,id'],
            'note' => ['nullable', 'string'],
            'po_file' => ['required', 'file', 'mimes:pdf', 'max:20480'],
        ];
    }
}

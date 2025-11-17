<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $clientId = $this->route('client')?->id;

        return [
            'client_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('clients', 'client_code')->ignore($clientId),
            ],
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                Rule::unique('clients', 'email')->ignore($clientId),
            ],
            'phone' => [
                'required',
                'string',
                'max:30',
                Rule::unique('clients', 'phone')->ignore($clientId),
            ],
            'agency' => ['nullable', 'string', 'max:255'],
            'currency' => ['nullable', 'string', 'max:50'],
        ];
    }
}

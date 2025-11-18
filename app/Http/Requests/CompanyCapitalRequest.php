<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyCapitalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'total_capital_egp' => ['required', 'string', 'max:255'],
            'total_capital_usd' => ['required', 'string', 'max:255'],
            'temporary_capital_egp' => ['required', 'string', 'max:255'],
            'temporary_capital_usd' => ['required', 'string', 'max:255'],
            'emergency_capital_egp' => ['required', 'string', 'max:255'],
            'emergency_capital_usd' => ['required', 'string', 'max:255'],
        ];
    }
}

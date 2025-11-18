<?php

namespace App\Http\Requests;

use App\Models\Client;
use App\Models\Freelancer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $taskId = $this->route('task')?->id;

        return [
            'task_number' => [
                'required',
                'string',
                'max:100',
                \Illuminate\Validation\Rule::unique('tasks', 'task_number')->ignore($taskId),
            ],
            'reference_number' => [
                'nullable',
                'string',
                'max:100',
                function ($attribute, $value, $fail) use ($taskId) {
                    if ($value) {
                        $referencedTask = \App\Models\Task::where('task_number', $value)->first();
                        if (!$referencedTask) {
                            $fail('The reference task number does not exist in the database.');
                        } elseif ($taskId && $referencedTask->id == $taskId) {
                            $fail('A task cannot reference itself.');
                        }
                    }
                },
            ],
            'page_numbers' => ['nullable', 'string', 'max:50'],
            'words_count' => ['nullable', 'string', 'max:50'],
            'client_code' => [
                'required',
                'string',
                'max:50',
                function ($attribute, $value, $fail) {
                    // Check if client_code exists in clients or freelancers
                    $existsInClients = Client::where('client_code', $value)->exists();
                    $existsInFreelancers = Freelancer::where('freelancer_code', $value)->exists();

                    if (!$existsInClients && !$existsInFreelancers) {
                        $fail('The client code does not exist in the database.');
                    }
                },
            ],
            'language_pair' => ['required', 'array', 'min:1'],
            'language_pair.*.source' => ['required', 'string', 'max:100'],
            'language_pair.*.target' => ['required', 'string', 'max:100'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'start_time' => ['required', 'regex:/^([0-1][0-9]|2[0-3]):[0-5][0-9](:00)?$/'],
            'end_time' => ['required', 'regex:/^([0-1][0-9]|2[0-3]):[0-5][0-9](:00)?$/'],
            'notes' => ['nullable', 'string'],
            'status' => ['required', 'in:pending,in_progress,completed'],
            'freelancer_codes' => ['nullable', 'array'],
            'freelancer_codes.*' => [
                'string',
                'max:50',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $exists = Freelancer::where('freelancer_code', $value)->exists();
                        if (!$exists) {
                            $fail('The freelancer code "' . $value . '" does not exist in the database.');
                        }
                    }
                },
            ],
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

@php
    $task = $task ?? new \App\Models\Task();
    $clients = $clients ?? collect();
    $services = $services ?? collect();
    $languageRows = collect(old('language_pair', $task->language_pair ?? []))
        ->map(
            fn($row) => [
                'source' => $row['source'] ?? '',
                'target' => $row['target'] ?? '',
            ],
        )
        ->filter(fn($row) => $row['source'] !== '' || $row['target'] !== '')
        ->values()
        ->all();

    if (empty($languageRows)) {
        $languageRows[] = ['source' => '', 'target' => ''];
    }

    $freelancerRows = collect(old('freelancer_codes', $task->freelancers->pluck('freelancer_code')->toArray() ?? []))
        ->filter(fn($code) => !empty($code))
        ->values()
        ->all();

    if (empty($freelancerRows)) {
        $freelancerRows[] = '';
    }
@endphp

<div class="row g-4">
    <div class="col-md-6">
        <label for="task_number" class="form-label">Task Number <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="task_number" name="task_number"
            value="{{ old('task_number', $taskNumber ?? ($task->task_number ?? '')) }}" readonly required>
        @error('task_number')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="client_code" class="form-label">Client Code <span class="text-danger">*</span></label>
        <div class="input-group">
            <input type="text" class="form-control" id="client_code" name="client_code"
                value="{{ old('client_code', $task->client_code ?? '') }}" required>
            <button type="button" class="btn btn-outline-primary" id="viewClientBtn" title="View Client Details">
                <i class="ti ti-external-link"></i>
            </button>
        </div>
        @error('client_code')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
        <div id="clientCodeError" class="text-danger small d-none"></div>
    </div>
    <div class="col-md-6">
        <label for="reference_number" class="form-label">Reference Task Number</label>
        <div class="input-group">
            <input type="text" class="form-control" id="reference_number" name="reference_number"
                value="{{ old('reference_number', $task->referencedTask->task_number ?? '') }}"
                placeholder="Enter task number">
            <button type="button" class="btn btn-outline-primary" id="viewReferenceTaskBtn"
                title="View Reference Task">
                <i class="ti ti-external-link"></i>
            </button>
        </div>
        @error('reference_number')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
        <div id="referenceTaskError" class="text-danger small d-none"></div>
    </div>
    <div class="col-md-6">
        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
        <select class="form-select" id="status" name="status" required>
            <option value="pending" {{ old('status', $task->status ?? '') === 'pending' ? 'selected' : '' }}>Pending
            </option>
            <option value="in_progress" {{ old('status', $task->status ?? '') === 'in_progress' ? 'selected' : '' }}>In
                Progress</option>
            <option value="completed" {{ old('status', $task->status ?? '') === 'completed' ? 'selected' : '' }}>
                Completed
            </option>
        </select>
        @error('status')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-3">
        <label for="page_numbers" class="form-label">Page Numbers</label>
        <input type="text" class="form-control" id="page_numbers" name="page_numbers"
            value="{{ old('page_numbers', $task->page_numbers ?? '') }}">
    </div>
    <div class="col-md-3">
        <label for="words_count" class="form-label">Words Count</label>
        <input type="text" class="form-control" id="words_count" name="words_count"
            value="{{ old('words_count', $task->words_count ?? '') }}">
    </div>
    <div class="col-md-3">
        <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
        <input type="date" class="form-control" id="start_date" name="start_date"
            value="{{ old('start_date', $task->start_date?->format('Y-m-d') ?? '') }}" required>
        @error('start_date')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-3">
        <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
        <input type="date" class="form-control" id="end_date" name="end_date"
            value="{{ old('end_date', $task->end_date?->format('Y-m-d') ?? '') }}" required>
        @error('end_date')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-3">
        <label for="start_time" class="form-label">Start Time <span class="text-danger">*</span></label>
        <input type="time" class="form-control" id="start_time" name="start_time"
            value="{{ old('start_time', $task->start_time ?? '') }}" required>
        @error('start_time')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-3">
        <label for="end_time" class="form-label">End Time <span class="text-danger">*</span></label>
        <input type="time" class="form-control" id="end_time" name="end_time"
            value="{{ old('end_time', $task->end_time ?? '') }}" required>
        @error('end_time')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-12">
        <label for="notes" class="form-label">Notes</label>
        <textarea class="form-control" id="notes" name="notes" rows="4">{{ old('notes', $task->notes ?? '') }}</textarea>
    </div>
    <div class="col-md-6">
        <label for="file_status" class="form-label">File Status</label>
        <select class="form-select" id="file_status" name="file_status">
            <option value="DTP" {{ old('file_status', 'DTP') === 'DTP' ? 'selected' : '' }}>DTP</option>
            <option value="Update" {{ old('file_status') === 'Update' ? 'selected' : '' }}>Update</option>
        </select>
        <small class="text-muted">Select status for uploaded files</small>
    </div>
    <div class="col-md-6">
        <label for="attachments" class="form-label">Attachments</label>
        <input type="file" class="form-control" id="attachments" name="attachments[]" multiple>
        <small class="text-muted">Images, PDF, Word, Excel up to 20MB each.</small>
    </div>
</div>

<div class="mt-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <label class="form-label mb-0">Language Pairs <span class="text-danger">*</span></label>
        <button type="button" class="btn btn-sm btn-outline-primary" id="addLanguageRow">
            <i class="ti ti-plus"></i> Add Language
        </button>
    </div>
    <div id="languageRows">
        @foreach ($languageRows as $index => $language)
            <div class="card mb-3 language-row" data-index="{{ $index }}">
                <div class="card-body row g-3 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label">Source</label>
                        <input type="text" class="form-control" name="language_pair[{{ $index }}][source]"
                            value="{{ $language['source'] }}" required>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Target</label>
                        <input type="text" class="form-control" name="language_pair[{{ $index }}][target]"
                            value="{{ $language['target'] }}" required>
                    </div>
                    <div class="col-md-2 d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-danger remove-language">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @error('language_pair')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>

<div class="mt-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <label class="form-label mb-0">Freelancers</label>
        <button type="button" class="btn btn-sm btn-outline-primary" id="addFreelancerRow">
            <i class="ti ti-plus"></i> Add Freelancer
        </button>
    </div>
    <div id="freelancerRows">
        @foreach ($freelancerRows as $index => $freelancerCode)
            <div class="card mb-3 freelancer-row" data-index="{{ $index }}">
                <div class="card-body row g-3 align-items-end">
                    <div class="col-md-10">
                        <label class="form-label">Freelancer Code</label>
                        <input type="text" class="form-control" name="freelancer_codes[{{ $index }}]"
                            value="{{ $freelancerCode }}" placeholder="Enter freelancer code">
                    </div>
                    <div class="col-md-2 d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-danger remove-freelancer">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @error('freelancer_codes')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
    @error('freelancer_codes.*')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>

<div class="mt-4">
    <label class="form-label mb-2">Services</label>
    <div class="row g-3">
        @forelse ($services as $service)
            <div class="col-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="service_ids[]"
                        value="{{ $service->id }}" id="service_{{ $service->id }}"
                        {{ (old('service_ids') && in_array($service->id, old('service_ids'))) ||
                        ($task->exists && $task->services->contains($service->id))
                            ? 'checked'
                            : '' }}>
                    <label class="form-check-label" for="service_{{ $service->id }}">
                        {{ $service->name }}
                    </label>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted mb-0">No services available.</p>
            </div>
        @endforelse
    </div>
    @error('service_ids')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>

@push('scripts')
    @once
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const container = document.getElementById('languageRows');
                const addBtn = document.getElementById('addLanguageRow');

                const getNextIndex = () => container.querySelectorAll('.language-row').length;

                addBtn?.addEventListener('click', () => {
                    const index = getNextIndex();
                    const wrapper = document.createElement('div');
                    wrapper.classList.add('card', 'mb-3', 'language-row');
                    wrapper.dataset.index = index;
                    wrapper.innerHTML = `
                        <div class="card-body row g-3 align-items-end">
                            <div class="col-md-5">
                                <label class="form-label">Source</label>
                                <input type="text" class="form-control" name="language_pair[${index}][source]" required>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Target</label>
                                <input type="text" class="form-control" name="language_pair[${index}][target]" required>
                            </div>
                            <div class="col-md-2 d-flex justify-content-end">
                                <button type="button" class="btn btn-outline-danger remove-language">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </div>
                        </div>
                        `;
                    container.appendChild(wrapper);
                });

                container?.addEventListener('click', (event) => {
                    if (event.target.closest('.remove-language')) {
                        const rows = container.querySelectorAll('.language-row');
                        if (rows.length === 1) {
                            alert('At least one language pair is required.');
                            return;
                        }
                        event.target.closest('.language-row').remove();
                    }
                });

                // Freelancers Management
                const freelancerContainer = document.getElementById('freelancerRows');
                const addFreelancerBtn = document.getElementById('addFreelancerRow');

                const getNextFreelancerIndex = () => freelancerContainer.querySelectorAll('.freelancer-row').length;

                addFreelancerBtn?.addEventListener('click', () => {
                    const index = getNextFreelancerIndex();
                    const wrapper = document.createElement('div');
                    wrapper.classList.add('card', 'mb-3', 'freelancer-row');
                    wrapper.dataset.index = index;
                    wrapper.innerHTML = `
                        <div class="card-body row g-3 align-items-end">
                            <div class="col-md-10">
                                <label class="form-label">Freelancer Code</label>
                                <input type="text" class="form-control" name="freelancer_codes[${index}]" placeholder="Enter freelancer code">
                            </div>
                            <div class="col-md-2 d-flex justify-content-end">
                                <button type="button" class="btn btn-outline-danger remove-freelancer">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </div>
                        </div>
                    `;
                    freelancerContainer.appendChild(wrapper);
                });

                freelancerContainer?.addEventListener('click', (event) => {
                    if (event.target.closest('.remove-freelancer')) {
                        const rows = freelancerContainer.querySelectorAll('.freelancer-row');
                        if (rows.length === 1) {
                            // Allow removing the last one, just clear it
                            const input = event.target.closest('.freelancer-row').querySelector('input');
                            if (input) input.value = '';
                        } else {
                            event.target.closest('.freelancer-row').remove();
                        }
                    }
                });

                // Reference Task Validation
                const referenceTaskInput = document.getElementById('reference_number');
                const viewReferenceTaskBtn = document.getElementById('viewReferenceTaskBtn');
                const referenceTaskError = document.getElementById('referenceTaskError');

                viewReferenceTaskBtn?.addEventListener('click', function() {
                    const taskNumber = referenceTaskInput.value.trim();

                    if (!taskNumber) {
                        referenceTaskError.textContent = 'Please enter a task number.';
                        referenceTaskError.classList.remove('d-none');
                        return;
                    }

                    // Disable button while searching
                    viewReferenceTaskBtn.disabled = true;
                    viewReferenceTaskBtn.innerHTML = '<i class="ti ti-loader-2"></i>';

                    // Try to find task by number
                    fetch(`{{ route('dashboard.tasks.find-task') }}?task_number=${encodeURIComponent(taskNumber)}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.found) {
                                window.location.href = data.url;
                            } else {
                                showTaskNotFound(data.message || 'Task with this number not found.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showTaskNotFound('An error occurred while searching. Please try again.');
                        })
                        .finally(() => {
                            viewReferenceTaskBtn.disabled = false;
                            viewReferenceTaskBtn.innerHTML = '<i class="ti ti-external-link"></i>';
                        });
                });

                function showTaskNotFound(message) {
                    referenceTaskError.textContent = message || 'Task with this number not found.';
                    referenceTaskError.classList.remove('d-none');
                    setTimeout(() => {
                        referenceTaskError.classList.add('d-none');
                    }, 5000);
                }
            });
        </script>
    @endonce
@endpush

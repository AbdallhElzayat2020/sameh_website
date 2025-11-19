@php
    $freelancer = $freelancer ?? new \App\Models\Freelancer();
    $services = $services ?? collect();
    $languageRows = collect(old('languages', $freelancer->language_pair ?? []))
        ->map(fn($row) => [
            'source' => $row['source'] ?? '',
            'target' => $row['target'] ?? '',
        ])
        ->filter(fn($row) => $row['source'] !== '' || $row['target'] !== '')
        ->values()
        ->all();

    if (empty($languageRows)) {
        $languageRows[] = ['source' => '', 'target' => ''];
    }
@endphp

<div class="row g-4">
    <div class="col-md-6">
        <label for="freelancer_code" class="form-label">Freelancer Code</label>
        <input type="text" class="form-control" id="freelancer_code" name="freelancer_code"
               readonly
            value="{{ old('freelancer_code', $f_code ?? $freelancer->freelancer_code ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $freelancer->name ?? '') }}"
            required>
    </div>
    <div class="col-md-6">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email"
            value="{{ old('email', $freelancer->email ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" class="form-control" id="phone" name="phone"
            value="{{ old('phone', $freelancer->phone ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label for="quota" class="form-label">Quota</label>
        <input type="text" class="form-control" id="quota" name="quota"
            value="{{ old('quota', $freelancer->quota ?? '') }}" required>
    </div>
    <div class="col-md-3">
        <label for="price_hr" class="form-label">Rate per hour</label>
        <input type="number" step="0.01" class="form-control" id="price_hr" name="price_hr"
            value="{{ old('price_hr', $freelancer->price_hr ?? '') }}" required>
    </div>
    <div class="col-md-3">
        <label for="currency" class="form-label">Currency</label>
        <input type="text" class="form-control" id="currency" name="currency"
            value="{{ old('currency', $freelancer->currency ?? '') }}" required>
    </div>
    <div class="col-12">
        <label class="form-label">Services</label>
        <div class="row">
            @foreach ($services as $service)
                <div class="col-md-4 mb-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="service-{{ $service->id }}" name="service_ids[]"
                            value="{{ $service->id }}" @checked(in_array($service->id, old('service_ids', $freelancer->services->pluck('id')->toArray() ?? [])))>
                        <label class="form-check-label" for="service-{{ $service->id }}">
                            {{ $service->name }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
        <small class="text-muted">Select the services this freelancer can handle.</small>
    </div>
    <div class="col-12">
        <label for="attachments" class="form-label">Attachments</label>
        <input type="file" class="form-control" id="attachments" name="attachments[]" multiple>
        <small class="text-muted">Upload resume, NDA, or other documents (max 20MB each).</small>
    </div>
</div>

<div class="mt-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <label class="form-label mb-0">Language Pairs</label>
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
                        <input type="text" class="form-control" name="languages[{{ $index }}][source]"
                            value="{{ $language['source'] }}" required>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Target</label>
                        <input type="text" class="form-control" name="languages[{{ $index }}][target]"
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
</div>

@push('scripts')
    @once
        <script>
            document.addEventListener('DOMContentLoaded', function () {
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
                                        <input type="text" class="form-control" name="languages[${index}][source]" required>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label">Target</label>
                                        <input type="text" class="form-control" name="languages[${index}][target]" required>
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
            });
        </script>
    @endonce
@endpush

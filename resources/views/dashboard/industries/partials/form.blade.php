@php
    use Illuminate\Support\Facades\Storage;
    $industry = $industry ?? new \App\Models\Industry();

    $oldOptions = old('options', []);
    $existingOptions =
        $industry->exists && $industry->industryOptions
        ? $industry->industryOptions->map(fn($opt) => ['id' => $opt->id, 'name' => $opt->name])->toArray()
        : [];

    $optionRows = !empty($oldOptions)
        ? collect($oldOptions)->map(fn($row) => ['id' => $row['id'] ?? null, 'name' => $row['name'] ?? ''])->all()
        : $existingOptions;

    if (empty($optionRows)) {
        $optionRows[] = ['id' => null, 'name' => ''];
    }
@endphp

<div class="row g-4">
    <div class="col-12">
        <label for="name" class="form-label">Industry Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $industry->name ?? '') }}"
            required>
        @error('name')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-12">
        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
        <textarea class="form-control" id="description" name="description" rows="5"
            required>{{ old('description', $industry->description ?? '') }}</textarea>
        @error('description')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-12">
        <label for="image" class="form-label">
            Industry Image
            @if (!$industry->exists)
                <span class="text-danger">*</span>
            @endif
        </label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*" {{ !$industry->exists ? 'required' : '' }}>
        @error('image')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
        @if ($industry->exists && $industry->media)
            <div class="mt-2">
                <small class="text-muted">Current image:</small>
                <div class="mt-2">
                    <img src="{{ asset('uploads/' . $industry->media->path) }}" alt="{{ $industry->name }}"
                        class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                </div>
            </div>
        @endif
        <small class="text-muted">Upload an image for this industry (max 5MB, formats: jpeg, png, jpg, gif,
            webp).</small>
    </div>
</div>

<div class="mt-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <label class="form-label mb-0">Options <span class="text-danger">*</span></label>
        <button type="button" class="btn btn-sm btn-outline-primary" id="addOptionRow">
            <i class="ti ti-plus"></i> Add Option
        </button>
    </div>
    <div id="optionRows">
        @foreach ($optionRows as $index => $option)
            <div class="card mb-3 option-row" data-index="{{ $index }}">
                <div class="card-body row g-3 align-items-end">
                    @if (isset($option['id']) && $option['id'])
                        <input type="hidden" name="options[{{ $index }}][id]" value="{{ $option['id'] }}">
                    @endif
                    <div class="col-md-10">
                        <label class="form-label">Option Name</label>
                        <input type="text" class="form-control" name="options[{{ $index }}][name]"
                            value="{{ $option['name'] }}" required>
                    </div>
                    <div class="col-md-2 d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-danger remove-option">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @error('options')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
    @error('options.*')
        <div class="text-danger small">{{ $message }}</div>
    @enderror
</div>

@push('scripts')
    @once
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const container = document.getElementById('optionRows');
                const addBtn = document.getElementById('addOptionRow');

                const getNextIndex = () => container.querySelectorAll('.option-row').length;

                addBtn?.addEventListener('click', () => {
                    const index = getNextIndex();
                    const wrapper = document.createElement('div');
                    wrapper.classList.add('card', 'mb-3', 'option-row');
                    wrapper.dataset.index = index;
                    wrapper.innerHTML = `
                                        <div class="card-body row g-3 align-items-end">
                                            <div class="col-md-10">
                                                <label class="form-label">Option Name</label>
                                                <input type="text" class="form-control" name="options[${index}][name]" required>
                                            </div>
                                            <div class="col-md-2 d-flex justify-content-end">
                                                <button type="button" class="btn btn-outline-danger remove-option">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        `;
                    container.appendChild(wrapper);
                });

                container?.addEventListener('click', (event) => {
                    if (event.target.closest('.remove-option')) {
                        const rows = container.querySelectorAll('.option-row');
                        if (rows.length === 1) {
                            alert('At least one option is required.');
                            return;
                        }
                        event.target.closest('.option-row').remove();
                    }
                });
            });
        </script>
    @endonce
@endpush

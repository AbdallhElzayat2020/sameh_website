@php
    $service = $service ?? new \App\Models\Service();
@endphp

<div class="row g-4">
    <div class="col-md-6">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name"
            value="{{ old('name', $service->name ?? '') }}" required>
        @error('name')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="status" class="form-label">Status</label>
        <select id="status" name="status" class="form-select" required>
            <option value="active" @selected(old('status', $service->status ?? 'active') === 'active')>Active</option>
            <option value="inactive" @selected(old('status', $service->status ?? 'active') === 'inactive')>Inactive
            </option>
        </select>
        @error('status')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-12">
        <label for="icon" class="form-label">
            Icon
            @if (!$service->exists)
                <span class="text-danger">*</span>
            @endif
        </label>
        <input type="file" class="form-control" id="icon" name="icon" accept="image/*"
            {{ !$service->exists ? 'required' : '' }}>
        @error('icon')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
        @if ($service->exists && $service->icon)
            <div class="mt-2">
                <small class="text-muted">Current icon:</small>
                <div class="mt-2">
                    <img src="{{ asset('uploads/' . $service->icon) }}" alt="{{ $service->name }}" class="img-thumbnail"
                        style="max-width: 100px; max-height: 100px;">
                </div>
            </div>
        @endif
        <small class="text-muted">Upload an icon image for this service (max 3MB, formats: jpeg, png, jpg, gif,
            webp).</small>
    </div>
    <div class="col-12">
        <label for="description" class="form-label">Description</label>
        <textarea id="description" name="description" rows="4" class="form-control" placeholder="Describe this service">{{ old('description', $service->description ?? '') }}</textarea>
        @error('description')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>
</div>

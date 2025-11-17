@php
    $service = $service ?? new \App\Models\Service();
@endphp

<div class="row g-4">
    <div class="col-md-6">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $service->name ?? '') }}"
            required>
    </div>
    <div class="col-md-6">
        <label for="status" class="form-label">Status</label>
        <select id="status" name="status" class="form-select" required>
            <option value="active" @selected(old('status', $service->status ?? 'active') === 'active')>Active</option>
            <option value="inactive" @selected(old('status', $service->status ?? 'active') === 'inactive')>Inactive
            </option>
        </select>
    </div>
    <div class="col-12">
        <label for="description" class="form-label">Description</label>
        <textarea id="description" name="description" rows="4" class="form-control"
            placeholder="Describe this service">{{ old('description', $service->description ?? '') }}</textarea>
    </div>
</div>

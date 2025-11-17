@php
    $testimonial = $testimonial ?? new \App\Models\Testimonial();
@endphp

<div class="row g-4">
    <div class="col-md-6">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name"
            value="{{ old('name', $testimonial->name ?? '') }}" required>
    </div>
    <div class="col-md-3">
        <label for="rate" class="form-label">Rating</label>
        <input type="number" min="1" max="5" class="form-control" id="rate" name="rate"
            value="{{ old('rate', $testimonial->rate ?? 5) }}" required>
    </div>
    <div class="col-md-3">
        <label for="status" class="form-label">Status</label>
        <select id="status" name="status" class="form-select" required>
            <option value="active" @selected(old('status', $testimonial->status ?? 'active') === 'active')>Active</option>
            <option value="inactive" @selected(old('status', $testimonial->status ?? 'active') === 'inactive')>Inactive
            </option>
        </select>
    </div>
    <div class="col-12">
        <label for="description" class="form-label">Description</label>
        <textarea id="description" name="description" rows="4" class="form-control"
            required>{{ old('description', $testimonial->description ?? '') }}</textarea>
    </div>
</div>

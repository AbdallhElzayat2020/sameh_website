@php
    use Illuminate\Support\Facades\Storage;
    $industry = $industry ?? new \App\Models\Industry();
@endphp

<div class="row g-4">
    <div class="col-12">
        <label for="name" class="form-label">Industry Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="name" name="name"
            value="{{ old('name', $industry->name ?? '') }}" required>
        @error('name')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-12">
        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
        <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description', $industry->description ?? '') }}</textarea>
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
        <input type="file" class="form-control" id="image" name="image" accept="image/*"
            {{ !$industry->exists ? 'required' : '' }}>
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

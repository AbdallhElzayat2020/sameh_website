@php
    $iosImage = $iosImage ?? new \App\Models\IosImage();
@endphp

<div class="row g-4">
    <div class="col-md-6">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title"
            value="{{ old('title', $iosImage->title ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label for="image" class="form-label">Image File</label>
        <input type="file" class="form-control" id="image" name="image" {{ $iosImage->exists ? '' : 'required' }}>
        <small class="text-muted">PNG/JPG up to 5MB.</small>
    </div>
</div>

@if ($iosImage->exists && $iosImage->img_path)
    <div class="mt-4">
        <label class="form-label d-block">Current Image</label>
        <img src="{{ asset('uploads/' . $iosImage->img_path) }}" alt="{{ $iosImage->title }}" class="rounded"
            style="max-width: 200px; height: auto;">
    </div>
@endif

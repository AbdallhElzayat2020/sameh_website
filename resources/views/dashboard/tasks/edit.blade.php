@extends('dashboard.layouts.master')
@section('title', 'Edit Task')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header border-0 bg-transparent pb-3">
            <h4 class="mb-1">Edit Task</h4>
            <p class="mb-0 text-muted">Update task information and files.</p>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('dashboard.tasks.update', $task) }}" enctype="multipart/form-data"
                id="taskForm">
                @csrf
                @method('PUT')
                @include('dashboard.tasks.partials.form')
                <div class="d-flex gap-2 justify-content-end mt-4">
                    <a href="{{ route('dashboard.tasks.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Task</button>
                </div>
            </form>
        </div>
    </div>

    @if ($task->exists)
        <div class="card shadow-sm border-0 mt-4">
            <div class="card-header border-0 bg-transparent pb-3">
                <h4 class="mb-1">Attachments</h4>
                <p class="mb-0 text-muted">Manage task files.</p>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <form method="POST" action="{{ route('dashboard.tasks.upload-files', $task) }}"
                        enctype="multipart/form-data" id="uploadFilesForm" class="d-inline">
                        @csrf
                        <div class="input-group">
                            <input type="file" class="form-control" name="attachments[]" multiple required>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-upload me-1"></i> Upload Files
                            </button>
                        </div>
                        <small class="text-muted">Upload files (max 20MB each).</small>
                    </form>
                </div>
                @if ($task->media->isNotEmpty())
                    <div class="list-group">
                        @foreach ($task->media->sortBy('created_at') as $media)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="fw-semibold d-block">{{ $media->original_name }}</span>
                                    <small class="text-muted">{{ strtoupper($media->type) }} •
                                        {{ number_format($media->size / 1024, 1) }} KB •
                                        {{ $media->created_at->format('d/m/Y h:i A') }}</small>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('dashboard.tasks.attachments.download', [$task, $media]) }}"
                                        class="btn btn-sm btn-outline-primary" target="_blank">
                                        <i class="ti ti-download"></i> Download
                                    </a>
                                    <form method="POST" class="m-0 d-inline"
                                        action="{{ route('dashboard.tasks.attachments.destroy', [$task, $media]) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this file?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="ti ti-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted mb-0">No files attached.</p>
                @endif
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const clientCodeInput = document.getElementById('client_code');
            const viewClientBtn = document.getElementById('viewClientBtn');
            const clientCodeError = document.getElementById('clientCodeError');

            viewClientBtn?.addEventListener('click', function () {
                const clientCode = clientCodeInput.value.trim();

                if (!clientCode) {
                    clientCodeError.textContent = 'Please enter a client code.';
                    clientCodeError.classList.remove('d-none');
                    return;
                }

                // Disable button while searching
                viewClientBtn.disabled = true;
                viewClientBtn.innerHTML = '<i class="ti ti-loader-2"></i>';

                // Try to find client or freelancer by code
                fetch(`{{ route('dashboard.tasks.find-client-or-freelancer') }}?code=${encodeURIComponent(clientCode)}`, {
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
                            showClientNotFound(data.message || 'Client or Freelancer with this code not found.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showClientNotFound('An error occurred while searching. Please try again.');
                    })
                    .finally(() => {
                        viewClientBtn.disabled = false;
                        viewClientBtn.innerHTML = '<i class="ti ti-external-link"></i>';
                    });
            });

            function showClientNotFound(message) {
                clientCodeError.textContent = message || 'Client or Freelancer with this code not found.';
                clientCodeError.classList.remove('d-none');
                setTimeout(() => {
                    clientCodeError.classList.add('d-none');
                }, 5000);
            }
        });
    </script>
@endpush

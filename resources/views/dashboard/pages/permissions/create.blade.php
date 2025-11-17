@extends('dashboard.layouts.master')
@section('title', 'إضافة صلاحية جديدة')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">إضافة صلاحية جديدة</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.permissions.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">اسم الصلاحية <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" 
                                   placeholder="مثال: create_users, edit_posts" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">استخدم صيغة snake_case مثل: create_users, edit_posts</small>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('dashboard.permissions.index') }}" class="btn btn-label-secondary">
                                إلغاء
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-check me-1"></i>
                                حفظ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@extends('dashboard.layouts.master')
@section('title', 'إضافة دور جديد')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">إضافة دور جديد</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.roles.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">اسم الدور <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">الصلاحيات</label>
                            <div class="row">
                                @foreach($permissions as $permission)
                                    <div class="col-md-3 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                   name="permissions[]" value="{{ $permission->id }}"
                                                   id="permission_{{ $permission->id }}"
                                                   {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('permissions')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('dashboard.roles.index') }}" class="btn btn-label-secondary">
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


@extends('dashboard.layouts.master')
@section('title', 'الأدوار')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">قائمة الأدوار</h5>
                    <a href="{{ route('dashboard.roles.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i>
                        إضافة دور جديد
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>اسم الدور</th>
                                    <th>الصلاحيات</th>
                                    <th>تاريخ الإنشاء</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roles as $role)
                                    <tr>
                                        <td>{{ $role->id }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            @if($role->permissions->count() > 0)
                                                <div class="d-flex flex-wrap gap-1">
                                                    @foreach($role->permissions->take(3) as $permission)
                                                        <span class="badge bg-label-info">{{ $permission->name }}</span>
                                                    @endforeach
                                                    @if($role->permissions->count() > 3)
                                                        <span
                                                            class="badge bg-label-secondary">+{{ $role->permissions->count() - 3 }}</span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">لا توجد صلاحيات</span>
                                            @endif
                                        </td>
                                        <td>{{ $role->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <div class="d-inline-block">
                                                <a href="{{ route('dashboard.roles.edit', $role) }}"
                                                    class="btn btn-sm btn-icon btn-label-primary">
                                                    <i class="ti ti-edit"></i>
                                                </a>
                                                <form action="{{ route('dashboard.roles.destroy', $role) }}" method="POST"
                                                    class="d-inline-block"
                                                    onsubmit="return confirm('هل أنت متأكد من حذف هذا الدور؟')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-icon btn-label-danger">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">لا توجد أدوار</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('dashboard.layouts.master')
@section('title', 'المستخدمين')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">قائمة المستخدمين</h5>
                    @can('Create User')
                        <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus me-1"></i>
                            إضافة مستخدم جديد
                        </a>
                    @endcan
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>الدور</th>
                                    <th>الحالة</th>
                                    <th>الهاتف</th>
                                    <th>تاريخ الإنشاء</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $canUpdateUser = Gate::allows('Update User');
                                    $canDeleteUser = Gate::allows('Delete User');
                                @endphp
                                @forelse($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->role)
                                                <span class="badge bg-label-primary">{{ $user->role->name }}</span>
                                            @else
                                                <span class="text-muted">بدون دور</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($user->status === 'active')
                                                <span class="badge bg-label-success">نشط</span>
                                            @else
                                                <span class="badge bg-label-danger">غير نشط</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->phone ?? '-' }}</td>
                                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <div class="d-inline-block">
                                                @if($canUpdateUser)
                                                    <a href="{{ route('dashboard.users.edit', $user) }}"
                                                        class="btn btn-sm btn-icon btn-label-primary">
                                                        <i class="ti ti-edit"></i>
                                                    </a>
                                                @endif
                                                @if($canDeleteUser && !$user->isAdministrator())
                                                    <form action="{{ route('dashboard.users.destroy', $user) }}" method="POST"
                                                        class="d-inline-block"
                                                        onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-icon btn-label-danger">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">لا توجد مستخدمين</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

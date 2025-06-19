@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- عنوان الصفحة ومسار التنقل --}}
        <div class="row">
            <div class="col-12">
                <h1 class="h3 mb-0 text-gray-800">إدارة المستخدمين</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home.dashboard') }}">لوحة التحكم</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">المستخدمين</li>
                    </ol>
                </nav>
            </div>
        </div>

        @include('components.alerts')

        {{-- إحصائيات المستخدمين --}}
        <div class="row mb-4 w-100 justify-content-between">
            {{-- إجمالي المستخدمين --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <x-stats-card icon="fas fa-users" title="إجمالي المستخدمين" :value="$usersCount" color="primary" />
            </div>

            {{-- المستخدمون النشطون --}}
            <div class="col-xl-3 col-md-6 mb-4">

                <x-stats-card icon="fas fa-user-check" title="المستخدمون النشطون" :value="$activeUsersCount" color="success" />
            </div>

            {{-- عدد المشرفين --}}
            <div class="col-xl-3 col-md-6 mb-4">

                <x-stats-card icon="fas fa-user-shield" title="عدد المشرفين" :value="$adminsCount" color="info" />
            </div>

            {{-- عدد الأدوار --}}
            <div class="col-xl-3 col-md-6 mb-4">

                <x-stats-card icon="fas fa-user-tag" title="عدد الأدوار" :value="count($roles)" color="warning" />
            </div>

        </div>

        {{-- بطاقة قائمة المستخدمين --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">قائمة المستخدمين</h6>
                <button class="btn btn-primary" data-toggle="modal" data-target="#createUserModal">
                    <i class="fas fa-plus"></i> إضافة مستخدم
                </button>
            </div>
            <div class="card-body">
                {{-- تبويب الأدوار --}}
                <ul class="nav nav-tabs mb-4">
                    <li class="nav-item">
                        <a class="nav-link {{ $selectedRole === 'all' ? 'active' : '' }}"
                            href="{{ route('users.index') }}">الكل</a>
                    </li>
                    @foreach ($roles as $role)
                        <li class="nav-item">
                            <a class="nav-link {{ $selectedRole === $role ? 'active' : '' }}"
                                href="{{ route('users.index', ['role' => $role]) }}">
                                {{ $role === 'admin' ? 'مدير' : ($role === 'moderator' ? 'مشرف' : ($role === 'vip' ? 'مميز' : 'عادي')) }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                {{-- نموذج البحث --}}
                <form action="{{ route('users.index') }}" method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                            placeholder="ابحث بالاسم أو البريد أو الهاتف..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> بحث
                            </button>
                        </div>
                    </div>
                </form>

                {{-- جدول المستخدمين --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>الصورة</th>
                                <th>الاسم</th>
                                <th>اسم المستخدم</th>
                                <th>الدور</th>
                                <th>البريد الإلكتروني</th>
                                <th>الحالة</th>
                                <th>العملات</th>
                                <th>المستوي</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{ $user->user_avatar }}"
                                            alt="{{ $user->name }}" class="rounded-circle" width="40" height="40">
                                    </td>
                                    <td>{{ \Illuminate\Support\Str::limit($user->name, 8) }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($user->username, 8) }}</td>
                                    <td>
                                        <span
                                            class="badge
                                            {{ $user->role === 'admin'
                                                ? 'badge-danger'
                                                : ($user->role === 'moderator'
                                                    ? 'badge-warning'
                                                    : ($user->role === 'vip'
                                                        ? 'badge-success'
                                                        : 'badge-secondary')) }}">
                                            {{ $user->role_name }}
                                        </span>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span
                                            class="badge
                                            {{ $user->status === 'active'
                                                ? 'badge-success'
                                                : ($user->status === 'inactive'
                                                    ? 'badge-secondary'
                                                    : 'badge-danger') }}">
                                            {{ $user->status_name }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ $user->coins }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-primary">{{ $user?->current_level?->name ?? 'بدون مستوى' }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            {{-- زر عرض --}}
                                            <button type="button" class="btn btn-sm btn-info" data-toggle="modal"
                                                data-target="#showUserModal{{ $user->id }}" title="عرض">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            {{-- زر تعديل --}}
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                data-target="#editUserModal{{ $user->id }}" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            {{-- زر حذف --}}
                                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                                data-target="#deleteUserModal{{ $user->id }}" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            {{-- /زر التاكيد والغاء التاكيد --}}
                                            <form action="{{ route('users.toggleIsVerified', $user->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    onclick="return confirm('{{ $user->is_verified ? 'هل تريد حذف التوثيق من المستخدم؟' : 'هل تريد اضافة التوثيق للمستخدم؟' }}')"
                                                    class="btn btn-sm btn-{{ $user->is_verified ? 'danger' : 'success' }}"
                                                    title="تحديث حالة التحقق">
                                                    <i class="fas fa-{{ $user->is_verified ? 'times' : 'check' }}"></i>
                                                </button>
                                            </form>

                                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                                                data-target="#changeLevelModal{{ $user->id }}" title="تغيير المستوى">
                                                <i class="fas fa-level-up-alt"></i>
                                            </button>
                                        </div>

                                        {{-- تضمين المودالات لكل مستخدم --}}
                                        @include('dashboard.users.modals.show', [
                                            'user' => $user,
                                        ])
                                        @include('dashboard.users.modals.edit', [
                                            'user' => $user,
                                        ])
                                        @include('dashboard.users.modals.delete', [
                                            'user' => $user,
                                        ])
                                        @include('dashboard.users.modals.set_level', [
                                            'user' => $user,
                                        ])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">لا يوجد مستخدمون</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- الترقيم --}}
                <div class="d-flex justify-content-center mt-4">
                    {{ $users->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- مودال إضافة مستخدم --}}
    @include('dashboard.users.modals.create')
@endsection

@push('scripts')
    <script>
        // عرض اسم الملف المختار في حقول upload
        $(document).ready(function() {
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').html(fileName);
            });

            // تفعيل التولتيب الافتراضي
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush

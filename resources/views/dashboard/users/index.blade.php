@extends('layouts.app')

@section('content')
    <div class="container mt-4 text-right">
        <h1>إدارة المستخدمين</h1>

        <!-- إحصائيات -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-users fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">إجمالي المستخدمين</h5>
                        <p class="display-4">{{ $totalUsers }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-user-check fa-3x text-success mb-3"></i>
                        <h5 class="card-title">المستخدمين النشطين</h5>
                        <p class="display-4">{{ $activeUsers }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-user-slash fa-3x text-danger mb-3"></i>
                        <h5 class="card-title">المستخدمين المحظورين</h5>
                        <p class="display-4">{{ $bannedUsers }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-flag fa-3x text-warning mb-3"></i>
                        <h5 class="card-title">الدولة الأكثر تسجيلًا</h5>
                        <p class="display-4 text-capitalize" style="font-size: 18px">
                            {{ $topCountry->country ?? 'غير محددة' }}</p>
                        <p class="text-muted">{{ $topCountry->count ?? 0 }} مستخدمين</p>
                    </div>
                </div>
            </div>
        </div>
        <form action="{{ route('users.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control"
                    placeholder="ابحث عن مستخدم (المعرف، الاسم، البريد، الهاتف)" value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">بحث</button>
            </div>
        </form>

        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addUserModal">إضافة مستخدم جديد</button>

        <!-- Tabs for filtering by status or roles -->
        <ul class="nav nav-tabs mb-3" id="userTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link {{ request('filter') == 'all' || !request('filter') ? 'active' : '' }}"
                    href="{{ route('users.index', ['filter' => 'all']) }}">
                    جميع المستخدمين
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('filter') == 'active' ? 'active' : '' }}"
                    href="{{ route('users.index', ['filter' => 'active']) }}">
                    المستخدمون النشطون
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('filter') == 'banned' ? 'active' : '' }}"
                    href="{{ route('users.index', ['filter' => 'banned']) }}">
                    المستخدمون المحظورون
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('filter') == 'admin' ? 'active' : '' }}"
                    href="{{ route('users.index', ['filter' => 'admin']) }}">
                    المسؤولون
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('filter') == 'moderator' ? 'active' : '' }}"
                    href="{{ route('users.index', ['filter' => 'moderator']) }}">
                    المشرفون
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('filter') == 'user' ? 'active' : '' }}"
                    href="{{ route('users.index', ['filter' => 'user']) }}">
                    المستخدمون
                </a>
            </li>
        </ul>
        @include('components.alerts')

        <table class="table table-bordered">
            @include('dashboard.users.table')
        </table>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                @include('dashboard.users.form', ['user' => null])
            </div>
        </div>
    </div>
@endsection

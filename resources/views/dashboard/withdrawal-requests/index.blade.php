@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- عنوان الصفحة ومسار التنقل --}}
        <div class="row">
            <div class="col-12">
                <h1 class="h3 mb-0 text-gray-800">إدارة طلبات السحب</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home.dashboard') }}">لوحة التحكم</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">طلبات السحب</li>
                    </ol>
                </nav>
            </div>
        </div>

        @include('components.alerts')

        {{-- إحصائيات طلبات السحب --}}
        <div class="row mb-4">
            {{-- إجمالي الطلبات --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <x-stats-card icon="fas fa-list-alt" title="إجمالي الطلبات" :value="$stats['total']" color="primary" />
            </div>
            {{-- الطلبات قيد الانتظار --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <x-stats-card icon="fas fa-hourglass-half" title="قيد الانتظار" :value="$stats['pending']" color="warning" />
            </div>
            {{-- الطلبات الموافق عليها --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <x-stats-card icon="fas fa-check-circle" title="موافق عليها" :value="$stats['approved']" color="success" />
            </div>
            {{-- الطلبات المرفوضة --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <x-stats-card icon="fas fa-times-circle" title="مرفوضة" :value="$stats['rejected']" color="danger" />
            </div>
        </div>

        {{-- بطاقة قائمة طلبات السحب --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">قائمة طلبات السحب</h6>
            </div>
            <div class="card-body">
                {{-- تبويب الحالات --}}
                <ul class="nav nav-tabs mb-4">
                    <li class="nav-item">
                        <a class="nav-link {{ request('status') == '' ? 'active' : '' }}"
                            href="{{ route('withdrawal-requests.index') }}">الكل</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}"
                            href="{{ route('withdrawal-requests.index', ['status' => 'pending']) }}">قيد الانتظار</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('status') == 'approved' ? 'active' : '' }}"
                            href="{{ route('withdrawal-requests.index', ['status' => 'approved']) }}">موافق عليها</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('status') == 'completed' ? 'active' : '' }}"
                            href="{{ route('withdrawal-requests.index', ['status' => 'completed']) }}">مكتملة</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('status') == 'rejected' ? 'active' : '' }}"
                            href="{{ route('withdrawal-requests.index', ['status' => 'rejected']) }}">مرفوضة</a>
                    </li>
                </ul>

                {{-- نموذج البحث --}}
                <form action="{{ route('withdrawal-requests.index') }}" method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                            placeholder="ابحث باسم المستخدم، البريد، أو اسم المحفظة..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> بحث
                            </button>
                        </div>
                    </div>
                </form>

                {{-- جدول الطلبات --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>المستخدم</th>
                                <th>المحفظة</th>
                                <th>المبلغ</th>
                                <th>الحالة</th>
                                <th>تاريخ الطلب</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($withdrawalRequests as $request)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $request->user->user_avatar }}"
                                                alt="{{ $request->user->name }}" class="rounded-circle mr-2" width="40"
                                                height="40">
                                            <div>
                                                <strong>{{ $request->user->name }}</strong><br>
                                                <small>{{ $request->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>{{ $request->wallet->wallet_name }}</strong><br>
                                        <small class="text-muted">{{ $request->wallet->wallet_type }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ number_format($request->amount, 2) }}</strong>
                                        <small>{{ $request->currency }}</small>
                                    </td>
                                    <td>
                                        @php
                                            $statusClasses = [
                                                'pending' => 'warning',
                                                'approved' => 'info',
                                                'completed' => 'success',
                                                'rejected' => 'danger',
                                            ];
                                            $statusNames = [
                                                'pending' => 'قيد الانتظار',
                                                'approved' => 'موافق عليه',
                                                'completed' => 'مكتمل',
                                                'rejected' => 'مرفوض',
                                            ];
                                        @endphp
                                        <span class="badge badge-{{ $statusClasses[$request->status] ?? 'secondary' }}">
                                            {{ $statusNames[$request->status] ?? $request->status }}
                                        </span>
                                    </td>
                                    <td>{{ $request->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        {{-- زر عرض --}}
                                        <button type="button" class="btn btn-sm btn-circle btn-info" data-toggle="modal"
                                            data-target="#showRequestModal{{ $request->id }}" title="عرض التفاصيل">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        {{-- زر تحديث الحالة --}}
                                        @if ($request->status === 'pending')
                                            <button type="button" class="btn btn-sm btn-circle btn-primary"
                                                data-toggle="modal" data-target="#updateStatusModal{{ $request->id }}"
                                                title="تحديث الحالة">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        @endif

                                        {{-- زر حذف --}}
                                        <button type="button" class="btn btn-sm btn-circle btn-danger" data-toggle="modal"
                                            data-target="#deleteRequestModal{{ $request->id }}" title="حذف الطلب">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                        {{-- تضمين المودالات لكل طلب --}}
                                        @include('dashboard.withdrawal-requests.modals.show', [
                                            'request' => $request,
                                        ])
                                        @include('dashboard.withdrawal-requests.modals.update_status', [
                                            'request' => $request,
                                        ])
                                        @include('dashboard.withdrawal-requests.modals.delete', [
                                            'request' => $request,
                                        ])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">لا توجد طلبات سحب حالياً.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- الترقيم --}}
                <div class="d-flex justify-content-center">
                    {{ $withdrawalRequests->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // تفعيل التولتيب الافتراضي
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endpush

@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- عنوان ومسار تنقل --}}
        <div class="row">
            <div class="col-12">
                <h1 class="h3 mb-0 text-gray-800">رسائل اتصل بنا</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home.dashboard') }}">لوحة التحكم</a></li>
                        <li class="breadcrumb-item active" aria-current="page">الرسائل</li>
                    </ol>
                </nav>
            </div>
        </div>

        @include('components.alerts')

        {{-- إحصائيات --}}
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <x-stats-card icon="fas fa-inbox" title="إجمالي الرسائل" :value="$total" color="primary" />
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <x-stats-card icon="fas fa-folder-open" title="المفتوحة" :value="$open" color="success" />
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <x-stats-card icon="fas fa-hourglass-half" title="قيد الانتظار" :value="$pending" color="warning" />
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <x-stats-card icon="fas fa-check-circle" title="المغلقة" :value="$closed" color="info" />
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">قائمة الرسائل</h6>
                <button class="btn btn-primary" data-toggle="modal" data-target="#createMessageModal">
                    <i class="fas fa-plus"></i> إضافة رسالة
                </button>
            </div>
            <div class="card-body">

                {{-- تبويب الحالة --}}
                <ul class="nav nav-tabs mb-4">
                    @php $statuses = ['all'=>'الكل','open'=>'مفتوحة','pending'=>'قيد الانتظار','closed'=>'مغلقة','spam'=>'سبام']; @endphp
                    @foreach ($statuses as $key => $label)
                        <li class="nav-item">
                            <a class="nav-link {{ $selectedStatus === $key ? 'active' : '' }}"
                                href="{{ route('contacts.index', ['status' => $key]) }}">{{ $label }}</a>
                        </li>
                    @endforeach
                </ul>

                {{-- البحث --}}
                <form action="{{ route('contacts.index') }}" method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="hidden" name="status" value="{{ $selectedStatus }}">
                        <input type="text" name="search" class="form-control"
                            placeholder="ابحث بالموضوع/المحتوى/البريد/الهاتف..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> بحث</button>
                        </div>
                    </div>
                </form>

                {{-- الجدول --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>المُرسِل</th>
                                <th>الموضوع</th>
                                <th>الحالة</th>
                                <th>الأولوية</th>
                                <th>المصدر</th>
                                <th>المُعيَّن له</th>
                                <th>التاريخ</th>
                                <th>إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($messages as $m)
                                <tr>
                                    <td>
                                        @if ($m->user)
                                            <span class="badge badge-info mr-1">مستخدم#{{ $m->user->id }}</span>
                                            {{ $m->user->name }}
                                        @else
                                            {{ $m->guest_name ?? 'زائر' }}<br>
                                            <small class="text-muted">{{ $m->guest_email }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $m->subject }}</strong>
                                        <div class="text-truncate" style="max-width: 240px;">
                                            {{ Str::limit($m->message, 60) }}</div>
                                    </td>
                                    <td><span class="badge badge-secondary">{{ $m->status->value }}</span></td>
                                    <td><span
                                            class="badge badge-{{ $m->priority->value == 'urgent' ? 'danger' : ($m->priority->value == 'high' ? 'warning' : 'secondary') }}">{{ $m->priority->value }}</span>
                                    </td>
                                    <td>{{ $m->source->value }}</td>
                                    <td>{{ optional($m->assignee)->name ?? '-' }}</td>
                                    <td>{{ $m->created_at->format('Y-m-d H:i') }}</td>
                                    <td class="text-nowrap">
                                        <button class="btn btn-sm btn-info" data-toggle="modal"
                                            data-target="#showMessageModal{{ $m->id }}"><i
                                                class="fas fa-eye"></i></button>
                                        <button class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#editMessageModal{{ $m->id }}"><i
                                                class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-danger" data-toggle="modal"
                                            data-target="#deleteMessageModal{{ $m->id }}"><i
                                                class="fas fa-trash"></i></button>

                                        {{-- مودالات الصف --}}
                                        @include('dashboard.contacts.modals.show', ['m' => $m])
                                        @include('dashboard.contacts.modals.edit', ['m' => $m])
                                        @include('dashboard.contacts.modals.delete', ['m' => $m])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">لا توجد رسائل</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center">
                    {{ $messages->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- مودال إنشاء (ثابت) --}}
    @include('dashboard.contacts.modals.create')
@endsection

@push('scripts')
    <script>
        // اسم الملف المختار
        $(document).on('change', '.custom-file-input', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').text(fileName);
        });
        $('[data-toggle="tooltip"]').tooltip();
    </script>
@endpush

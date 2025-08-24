@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- عنوان الصفحة ومسار التنقل --}}
        <div class="row">
            <div class="col-12">
                <h1 class="h3 mb-0 text-gray-800">إدارة البث المباشر</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home.dashboard') }}">لوحة التحكم</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">البث المباشر</li>
                    </ol>
                </nav>
            </div>
        </div>

        @include('components.alerts')

        {{-- إحصائيات البث المباشر --}}
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <x-stats-card icon="fas fa-video" title="إجمالي البث" :value="$stats['total']" color="primary" />
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <x-stats-card icon="fas fa-satellite-dish" title="بث مباشر حالي" :value="$stats['live']" color="success" />
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <x-stats-card icon="fas fa-calendar-alt" title="بث مجدول" :value="$stats['scheduled']" color="info" />
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <x-stats-card icon="fas fa-check-circle" title="بث منتهي" :value="$stats['ended']" color="warning" />
            </div>
        </div>

        {{-- بطاقة قائمة البث المباشر --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">قائمة البث المباشر</h6>
                <button class="btn btn-primary" data-toggle="modal" data-target="#createLiveStreamingModal">
                    <i class="fas fa-plus"></i> إضافة بث جديد
                </button>
            </div>
            <div class="card-body">
                {{-- تبويب الحالات --}}
                <ul class="nav nav-tabs mb-4">
                    <li class="nav-item">
                        <a class="nav-link {{ $selectedStatus === 'all' ? 'active' : '' }}"
                            href="{{ route('live-streamings.index') }}">الكل</a>
                    </li>
                    @foreach ($statuses as $status)
                        <li class="nav-item">
                            <a class="nav-link {{ $selectedStatus === $status ? 'active' : '' }}"
                                href="{{ route('live-streamings.index', ['status' => $status]) }}">
                                @php
                                    $statusNames = [
                                        'scheduled' => 'مجدول',
                                        'live' => 'مباشر',
                                        'ended' => 'منتهي',
                                    ];
                                @endphp
                                {{ $statusNames[$status] ?? $status }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                {{-- نموذج البحث --}}
                <form action="{{ route('live-streamings.index') }}" method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                            placeholder="ابحث بالعنوان، الوصف أو اسم المستخدم..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> بحث
                            </button>
                        </div>
                    </div>
                </form>

                {{-- جدول البث المباشر --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>العنوان</th>
                                <th>المستخدم</th>
                                <th>النوع</th>
                                <th>الحالة</th>
                                <th>الإعجابات</th>
                                <th>مجدول في</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($liveStreamings as $stream)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $stream->thumbnail ? asset('storage/' . $stream->thumbnail) : asset('img/default-thumbnail.png') }}"
                                                alt="{{ $stream->title }}" class="rounded mr-2" width="50"
                                                height="50" style="object-fit: cover;">
                                            {{ Str::limit($stream->title, 30) }}
                                        </div>
                                    </td>
                                    <td>{{ $stream->user->name ?? 'غير محدد' }}</td>
                                    <td>
                                        <span
                                            class="badge badge-pill badge-{{ $stream->type == 'live' ? 'info' : 'secondary' }}">
                                            {{ $stream->type == 'live' ? 'بث مرئي' : 'غرفة صوتية' }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $statusClasses = [
                                                'scheduled' => 'info',
                                                'live' => 'success',
                                                'ended' => 'danger',
                                            ];
                                            $statusNames = [
                                                'scheduled' => 'مجدول',
                                                'live' => 'مباشر',
                                                'ended' => 'منتهي',
                                            ];
                                        @endphp
                                        <span class="badge badge-{{ $statusClasses[$stream->status] ?? 'secondary' }}">
                                            {{ $statusNames[$stream->status] ?? $stream->status }}
                                        </span>
                                    </td>
                                    <td><i class="fas fa-thumbs-up text-primary"></i> {{ $stream->likes }}</td>
                                    <td>{{ $stream->scheduled_at ? $stream->scheduled_at->format('Y-m-d H:i A') : '-' }}
                                    </td>
                                    <td>
                                        {{-- زر عرض --}}
                                        <button type="button" class="btn btn-sm btn-circle btn-info" data-toggle="modal"
                                            data-target="#showLiveStreamingModal{{ $stream->id }}" title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        {{-- زر تعديل --}}
                                        <button type="button" class="btn btn-sm btn-circle btn-primary" data-toggle="modal"
                                            data-target="#editLiveStreamingModal{{ $stream->id }}" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        {{-- زر حذف --}}
                                        <button type="button" class="btn btn-sm btn-circle btn-danger" data-toggle="modal"
                                            data-target="#deleteLiveStreamingModal{{ $stream->id }}" title="حذف">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                        {{-- تضمين المودالات لكل بث --}}
                                        @include('dashboard.live_streamings.modals.show', [
                                            'stream' => $stream,
                                        ])
                                        @include('dashboard.live_streamings.modals.edit', [
                                            'stream' => $stream,
                                        ])
                                        @include('dashboard.live_streamings.modals.delete', [
                                            'stream' => $stream,
                                        ])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">لا يوجد بيانات بث مباشر</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- الترقيم --}}
                <div class="d-flex justify-content-center">
                    {{ $liveStreamings->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- مودال إضافة بث جديد (ثابت) --}}
    @include('dashboard.live_streamings.modals.create')
@endsection

@push('scripts')
    {{-- عرض اسم الملف المختار في حقول upload --}}
    <script>
        $('.custom-file-input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });

        {{-- تفعيل التولتيب الافتراضي --}}
        $('[data-toggle="tooltip"]').tooltip();
    </script>
@endpush

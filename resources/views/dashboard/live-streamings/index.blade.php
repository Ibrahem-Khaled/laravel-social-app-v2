@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- عنوان الصفحة ومسار التنقل --}}
        <div class="row">
            <div class="col-12">
                <h1 class="h3 mb-0 text-gray-800">إدارة البثوث المباشرة</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home.dashboard') }}">لوحة التحكم</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">البثوث المباشرة</li>
                    </ol>
                </nav>
            </div>
        </div>

        @include('components.alerts')

        {{-- إحصائيات البثوث --}}
        <div class="row mb-4">
            {{-- إجمالي البثوث --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <x-stats-card icon="fas fa-video" title="إجمالي البثوث" :value="$totalStreams" color="primary" />
            </div>
            {{-- البثوث النشطة --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <x-stats-card icon="fas fa-broadcast-tower" title="البثوث النشطة" :value="$activeStreams" color="success" />
            </div>
            {{-- بثوث فيديو --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <x-stats-card icon="fas fa-tv" title="بثوث فيديو" :value="$liveStreams" color="info" />
            </div>
            {{-- غرف صوتية --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <x-stats-card icon="fas fa-microphone" title="غرف صوتية" :value="$audioRooms" color="warning" />
            </div>
        </div>

        {{-- بطاقة قائمة البثوث --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">قائمة البثوث المباشرة</h6>
                <div>
                    <a href="{{ route('live-streamings.statistics') }}" class="btn btn-info mr-2">
                        <i class="fas fa-chart-bar"></i> الإحصائيات
                    </a>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#createStreamModal">
                        <i class="fas fa-plus"></i> بث جديد
                    </button>
                </div>
            </div>
            <div class="card-body">
                {{-- تبويب أنواع البثوث --}}
                <ul class="nav nav-tabs mb-4">
                    <li class="nav-item">
                        <a class="nav-link {{ !request()->has('type') ? 'active' : '' }}"
                            href="{{ route('live-streamings.index') }}">الكل</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('type') === 'live' ? 'active' : '' }}"
                            href="{{ route('live-streamings.index', ['type' => 'live']) }}">بثوث فيديو</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('type') === 'audio_room' ? 'active' : '' }}"
                            href="{{ route('live-streamings.index', ['type' => 'audio_room']) }}">غرف صوتية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('status') === '1' ? 'active' : '' }}"
                            href="{{ route('live-streamings.index', ['status' => '1']) }}">نشطة</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('status') === '0' ? 'active' : '' }}"
                            href="{{ route('live-streamings.index', ['status' => '0']) }}">غير نشطة</a>
                    </li>
                </ul>

                {{-- نموذج البحث --}}
                <form action="{{ route('live-streamings.index') }}" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-8">
                            <input type="text" name="search" class="form-control"
                                placeholder="ابحث بالعنوان أو الوصف..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <select name="agency_id" class="form-control">
                                <option value="">كل الوكالات</option>
                                @foreach (App\Models\Agency::all() as $agency)
                                    <option value="{{ $agency->id }}"
                                        {{ request('agency_id') == $agency->id ? 'selected' : '' }}>
                                        {{ $agency->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary btn-block" type="submit">
                                <i class="fas fa-search"></i> بحث
                            </button>
                        </div>
                    </div>
                </form>

                {{-- جدول البثوث --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>الصورة</th>
                                <th>العنوان</th>
                                <th>النوع</th>
                                <th>المستخدم</th>
                                <th>الوكالة</th>
                                <th>التفاعل</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($streams as $stream)
                                <tr>
                                    <td>
                                        @if ($stream->thumbnail)
                                            <img src="{{ asset('storage/' . $stream->thumbnail) }}"
                                                alt="{{ $stream->title }}" class="img-thumbnail" width="80">
                                        @else
                                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center"
                                                style="width: 80px; height: 60px;">
                                                <i class="fas fa-video"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $stream->title }}</strong>
                                        @if ($stream->scheduled_at && $stream->scheduled_at > now())
                                            <br>
                                            <small class="text-muted">
                                                <i class="fas fa-clock"></i>
                                                {{ $stream->scheduled_at->format('Y-m-d H:i') }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($stream->type == 'live')
                                            <span class="badge badge-primary">
                                                <i class="fas fa-tv"></i> فيديو
                                            </span>
                                        @else
                                            <span class="badge badge-info">
                                                <i class="fas fa-microphone"></i> صوت
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $stream->user->name }}</td>
                                    <td>{{ $stream->agency ? $stream->agency->name : '-' }}</td>
                                    <td>
                                        <span class="badge badge-success">
                                            <i class="fas fa-heart"></i> {{ $stream->likes }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $stream->status ? 'success' : 'danger' }}">
                                            {{ $stream->status ? 'نشط' : 'غير نشط' }}
                                        </span>
                                    </td>
                                    <td>
                                        {{-- زر عرض --}}
                                        <button type="button" class="btn btn-sm btn-circle btn-info" data-toggle="modal"
                                            data-target="#showStreamModal{{ $stream->id }}" title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        {{-- زر تعديل --}}
                                        <button type="button" class="btn btn-sm btn-circle btn-primary"
                                            data-toggle="modal" data-target="#editStreamModal{{ $stream->id }}"
                                            title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        {{-- زر حذف --}}
                                        <button type="button" class="btn btn-sm btn-circle btn-danger"
                                            data-toggle="modal" data-target="#deleteStreamModal{{ $stream->id }}"
                                            title="حذف">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                        {{-- تضمين المودالات لكل بث --}}
                                        @include('dashboard.live-streamings.modals.show', [
                                            'stream' => $stream,
                                        ])
                                        @include('dashboard.live-streamings.modals.edit', [
                                            'stream' => $stream,
                                        ])
                                        @include('dashboard.live-streamings.modals.delete', [
                                            'stream' => $stream,
                                        ])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">لا يوجد بثوث مباشرة</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- الترقيم --}}
                <div class="d-flex justify-content-center">
                    {{ $streams->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- مودال إنشاء بث جديد --}}
    <div class="modal fade" id="createStreamModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                @include('dashboard.live-streamings.modals.create')
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // عرض اسم الملف المختار في حقول upload
        $('.custom-file-input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });

        // تفعيل datetimepicker للتواريخ
        $('.datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD HH:mm',
            sideBySide: true,
            locale: 'ar'
        });

        // تفعيل التولتيب الافتراضي
        $('[data-toggle="tooltip"]').tooltip();
    </script>
@endpush

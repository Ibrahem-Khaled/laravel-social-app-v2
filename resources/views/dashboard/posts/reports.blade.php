@extends('layouts.app')

@section('content')
<div class="container mt-4 text-right">

    {{-- رسائل النجاح --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>إدارة البلاغات</h1>
        <div>
            <a href="{{ route('reports.index') }}" class="btn btn-primary">البلاغات الجديدة</a>
            <a href="{{ route('reports.index', ['hidden' => '1']) }}" class="btn btn-secondary">البلاغات المكتملة (المخفية)</a>
        </div>
    </div>

    <!-- التقارير والإحصائيات -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <h5 class="card-title">إجمالي البلاغات الجديدة</h5>
                    <p class="card-text display-4">{{ $totalReports }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <h5 class="card-title">بلاغات على المنشورات</h5>
                    <p class="card-text display-4">{{ $reportedPosts }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title text-center">أكثر الأسباب شيوعًا</h5>
                    <ul class="list-group list-group-flush">
                        @forelse ($topReasons as $reason)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $reason->reason }}
                                <span class="badge badge-primary badge-pill">{{ $reason->count }}</span>
                            </li>
                        @empty
                            <li class="list-group-item text-center">لا توجد بيانات</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- جدول البلاغات -->
    <div class="card">
        <div class="card-header">
            قائمة البلاغات
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>المُبلِّغ</th>
                        <th>المحتوى المُبلغ عنه</th>
                        <th>السبب</th>
                        <th>التفاصيل</th>
                        <th>تاريخ البلاغ</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reports as $report)
                        <tr>
                            <td>{{ $report->id }}</td>
                            <td>{{ $report->user->name ?? 'مستخدم محذوف' }}</td>
                            <td>
                                {{-- التعامل مع أنواع المحتوى المختلفة --}}
                                @if ($report->reportable)
                                    @if ($report->related_type == 'App\Models\Post')
                                        <span class="badge badge-info">منشور</span>
                                        <p class="mt-2 mb-0">"{{ Str::limit($report->reportable->content, 70) }}"</p>
                                    @elseif ($report->related_type == 'App\Models\User')
                                        <span class="badge badge-warning">مستخدم</span>
                                        <p class="mt-2 mb-0">"{{ $report->reportable->name }}"</p>
                                    @else
                                        <span class="badge badge-secondary">{{ class_basename($report->related_type) }}</span>
                                    @endif
                                @else
                                    <span class="text-danger">محتوى محذوف</span>
                                @endif
                            </td>
                            <td>{{ $report->reason }}</td>
                            <td>{{ $report->details ?? 'لا توجد' }}</td>
                            <td>{{ $report->created_at->diffForHumans() }}</td>
                            <td>
                                <form action="{{ route('reports.toggleVisibility', $report->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    @if ($report->is_hidden)
                                        <button type="submit" class="btn btn-success btn-sm">إعادة الفتح</button>
                                    @else
                                        <button type="submit" class="btn btn-secondary btn-sm">وضع كمكتمل</button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">لا توجد بلاغات تطابق هذا الفلتر.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $reports->appends(request()->query())->links() }}
    </div>
</div>
@endsection

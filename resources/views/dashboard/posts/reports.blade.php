@extends('layouts.app')

@section('content')
    <div class="container mt-4 text-right">
        <h1>إدارة البلاغات</h1>
        <a href="{{ route('reports.index', ['hidden' => true]) }}" class="btn btn-secondary mb-3">
            عرض البلاغات المخفية
        </a>
        <!-- التقارير والإحصائيات -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">إجمالي البلاغات</h5>
                        <p class="card-text">{{ $totalReports }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">عدد المنشورات المبلغ عنها</h5>
                        <p class="card-text">{{ $reportedPosts }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">أكثر الأسباب شيوعًا</h5>
                        <ul class="list-group">
                            @foreach ($topReasons as $reason)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $reason->reason }}
                                    <span class="badge badge-primary badge-pill">{{ $reason->count }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- جدول البلاغات -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>المعرف</th>
                    <th>معرف المستخدم</th>
                    <th>المستخدم</th>
                    <th>المنشور</th>
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
                        <td>{{ $report->user->uuid }}</td>
                        <td>{{ $report->user->username }}</td>
                        <td>
                            <!-- زر لعرض التفاصيل -->
                            <button class="btn btn-link" data-toggle="collapse"
                                data-target="#postDetails{{ $report->id }}" aria-expanded="false"
                                aria-controls="postDetails{{ $report->id }}">
                                {{ Str::limit($report->post->content, 50) }}
                            </button>

                            <!-- عرض تفاصيل المنشور -->
                            <div class="collapse mt-2" id="postDetails{{ $report->id }}">
                                <div class="card card-body">
                                    <h5>محتوى المنشور:</h5>
                                    <p>{{ $report->post->content }}</p>
                                    @if ($report->post->media)
                                        <h5 class="mt-3">الوسائط:</h5>
                                        <img src="{{ $report->post->media }}" alt="media" class="img-fluid">
                                    @endif
                                    <h5 class="mt-3">الحالة:</h5>
                                    <p>{{ $report->post->status }}</p>
                                    <h5 class="mt-3">تم النشر منذ:</h5>
                                    <p>{{ $report->post->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </td>
                        <td>{{ $report->reason }}</td>
                        <td>{{ $report->details ?? 'لا توجد تفاصيل' }}</td>
                        <td>{{ $report->created_at->diffForHumans() }}</td>
                        <td>
                            @if ($report->is_hidden)
                                <span class="badge badge-secondary">مخفي</span>
                                <form action="{{ route('reports.toggleVisibility', $report->id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-warning btn-sm">إظهار</button>
                                </form>
                            @else
                                <form action="{{ route('reports.toggleVisibility', $report->id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-danger btn-sm">إخفاء</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">لا توجد بلاغات</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $reports->links() }}
        </div>
    </div>
@endsection

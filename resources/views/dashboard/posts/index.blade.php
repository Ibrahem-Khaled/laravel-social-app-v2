@extends('layouts.app')

@section('content')
    <div class="container mt-4 text-right">
        <h1>إدارة المنشورات</h1>

        <!-- الإحصائيات -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">إجمالي المنشورات</h5>
                        <p class="card-text">{{ $totalPosts }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">المنشورات بدون وسائط</h5>
                        <p class="card-text">{{ $postsWithoutMedia }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">المنشورات وسائط فقط</h5>
                        <p class="card-text">{{ $postsMediaOnly }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">المنشورات وسائط ومحتوى</h5>
                        <p class="card-text">{{ $postsMediaAndContent }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">المنشورات المثبتة</h5>
                        <p class="card-text">{{ $pinnedPosts }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">المنشورات النشطة</h5>
                        <p class="card-text">{{ $activePosts }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- البحث والمنشورات -->
        <form action="{{ route('posts.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="ابحث عن منشور أو مستخدم"
                    value="{{ request('search') }}">
                <select name="status" class="form-control">
                    <option value="">كل الحالات</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشط</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                    <option value="banned" {{ request('status') == 'banned' ? 'selected' : '' }}>محظور</option>
                </select>
                <button type="submit" class="btn btn-primary">بحث</button>
            </div>
        </form>

        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addPostModal">إضافة منشور جديد</button>

        @include('components.alerts')

        <!-- جدول المنشورات -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>المعرف</th>
                    <th>المستخدم</th>
                    <th>المحتوى</th>
                    <th>الحالة</th>
                    <th>مثبت</th>
                    <th>التاريخ</th>
                    <th>البلاغات</th>
                    <th>التعليقات</th>
                    <th>الإعجابات</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->user->name }}</td>
                        <td>{{ Str::limit($post->content, 50) }}</td>
                        <td>{{ $post->status }}</td>
                        <td>{{ $post->pinned ? 'نعم' : 'لا' }}</td>
                        <td>
                            <small class="text-muted">منذ {{ $post->created_at->diffForHumans() }}</small>
                        </td>
                        <td>
                            @if ($post->reports->count() > 0)
                                <span class="badge badge-danger">
                                    {{ $post->reports->count() }} بلاغات
                                </span>
                                <a href="{{ route('reports.index', ['post_id' => $post->id]) }}"
                                    class="btn btn-warning btn-sm">
                                    عرض البلاغات
                                </a>
                            @else
                                <span class="badge badge-success">لا توجد بلاغات</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-info">{{ $post->comments->count() }} تعليقات</span>
                        </td>
                        <td>
                            <span class="badge badge-primary">{{ $post->likes->count() }} إعجابات</span>
                        </td>
                        <td>
                            <button class="btn btn-success" data-toggle="modal"
                                data-target="#editPostModal{{ $post->id }}">تعديل</button>
                            <form action="{{ route('posts.destroy', $post) }}" method="POST"
                                style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">لا توجد منشورات</td>
                    </tr>
                @endforelse
            </tbody>
        </table>


        <div class="mt-3">
            {{ $posts->links() }}
        </div>
    </div>

    <!-- Add Post Modal -->
    <div class="modal fade" id="addPostModal" tabindex="-1" aria-labelledby="addPostModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                @include('dashboard.posts.form', ['post' => null])
            </div>
        </div>
    </div>
@endsection

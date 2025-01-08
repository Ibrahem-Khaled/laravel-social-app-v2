@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="text-center">لوحة التحكم</h1>

        <!-- الإحصائيات الإجمالية -->
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-3x mb-2"></i>
                        <h3>{{ $totalUsers }}</h3>
                        <p>إجمالي المستخدمين</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-user-check fa-3x mb-2"></i>
                        <h3>{{ $activeUsers }}</h3>
                        <p>المستخدمين النشطين</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-dark">
                    <div class="card-body text-center">
                        <i class="fas fa-user-times fa-3x mb-2"></i>
                        <h3>{{ $inactiveUsers }}</h3>
                        <p>المستخدمين الغير نشطين</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-id-card fa-3x mb-2"></i>
                        <h3>{{ $totalVerificationRequests }}</h3>
                        <p>طلبات التحقق</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- الإحصائيات الأخرى -->
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-newspaper fa-3x mb-2"></i>
                        <h3>{{ $totalPosts }}</h3>
                        <p>إجمالي المنشورات</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-secondary text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-comments fa-3x mb-2"></i>
                        <h3>{{ $totalComments }}</h3>
                        <p>إجمالي التعليقات</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-dark text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-envelope fa-3x mb-2"></i>
                        <h3>{{ $totalMessages }}</h3>
                        <p>إجمالي الرسائل</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <i class="fas fa-exclamation-triangle fa-3x text-danger mb-2"></i>
                        <h3 class="text-danger">{{ $totalReports }}</h3>
                        <p>إجمالي البلاغات</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <i class="fas fa-gift fa-3x text-success mb-2"></i>
                        <h3 class="text-success">{{ $totalGifts }}</h3>
                        <p>إجمالي الهدايا</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- الإحصائيات الإضافية -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <i class="fas fa-thumbs-up fa-3x text-primary mb-2"></i>
                        <h3 class="text-primary">{{ $totalLikes }}</h3>
                        <p>إجمالي الإعجابات</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <i class="fas fa-share-alt fa-3x text-info mb-2"></i>
                        <h3 class="text-info">{{ $totalShares }}</h3>
                        <p>إجمالي المشاركات</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- المنشورات الأكثر تفاعلاً -->
        <div class="row mt-5">
            <div class="col-md-12">
                <h4 class="text-center">أكثر المنشورات تفاعلاً</h4>
                <ul class="list-group">
                    @foreach ($topPosts as $post)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                {{ Str::limit($post->content, 50) }}
                                <span class="text-muted">({{ $post?->created_at?->diffForHumans() }})</span>
                            </span>
                            <span>
                                <span class="badge bg-info">تعليقات: {{ $post->comments_count }}</span>
                                <span class="badge bg-primary">إعجابات: {{ $post->likes_count }}</span>
                                <span class="badge bg-warning">مشاركات: {{ $post->shares_count }}</span>
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection

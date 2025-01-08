@extends('layouts.app')

@section('content')
    <div class="container mt-4 text-right">
        <h1 class="text-center mb-4">الملف الشخصي للمستخدم</h1>
        <div class="row">
            <!-- صورة المستخدم -->
            <div class="col-md-4">
                <div class="card">
                    <img src="{{ $user->avatar ?? 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ficon-library.com%2Fimages%2Fdefault-user-icon%2Fdefault-user-icon-18.jpg&f=1&nofb=1&ipt=d0f5af5dfc777adac7f8d85dd353386af05fd82ab611836b115c56e5c1348fbd&ipo=images' }}"
                        alt="Avatar" class="card-img-top">
                    <div class="card-body text-center">
                        <h3 class="card-title">
                            {{ $user->name }}
                            @if ($user->is_verified && $user->role == 'user')
                                <i class="fas fa-check-circle text-primary" title="موثق"></i>
                            @elseif(($user->is_verified && $user->role == 'admin') || $user->role == 'moderator')
                                <i class="fas fa-check-circle text-success" title="موثق"></i>
                            @elseif($user->is_verified && $user->role == 'vip')
                                <i class="fas fa-check-circle text-warning" title="موثق"></i>
                            @endif
                        </h3>
                        <p class="card-text text-muted">{{ $user->username }}</p>
                        <p class="badge bg-info text-white" style="font-size: 14px">{{ $user->role }}</p>
                        <p style="font-size: 14px"
                            class="badge  {{ $user->status == 'banned' ? 'bg-danger' : 'bg-success' }} text-white ">
                            {{ $user->status == 'banned' ? 'محظور' : 'نشط' }}
                        </p>
                    </div>
                </div>
            </div>


            <!-- بيانات المستخدم -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-3">تفاصيل المستخدم</h4>
                        <ul class="list-group text-end">
                            <li class="list-group-item d-flex justify-content-between" style="flex-direction: row-reverse;">
                                <strong>:المعرف التعريفي</strong>
                                <span class="text-muted">{{ $user->uuid }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between" style="flex-direction: row-reverse;">
                                <strong>:البريد الإلكتروني</strong>
                                <span class="text-muted">{{ $user->email }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between" style="flex-direction: row-reverse;">
                                <strong>:الاسم الكامل</strong>
                                <span class="text-muted">{{ $user->name ?? 'غير متوفر' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between" style="flex-direction: row-reverse;">
                                <strong>:الهاتف</strong>
                                <span class="text-muted">{{ $user->phone ?? 'غير متوفر' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between" style="flex-direction: row-reverse;">
                                <strong>:الدولة</strong>
                                <span class="text-muted">{{ $user->country ?? 'غير محددة' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between" style="flex-direction: row-reverse;">
                                <strong>:العنوان</strong>
                                <span class="text-muted">{{ $user->address ?? 'غير متوفر' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between" style="flex-direction: row-reverse;">
                                <strong>:الموقع</strong>
                                <a href="{{ $user->website }}" target="_blank"
                                    class="text-muted">{{ $user->website ?? 'غير متوفر' }}</a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between" style="flex-direction: row-reverse;">
                                <strong>:الجنس</strong>
                                <span class="text-muted">{{ $user->gender == 'male' ? 'ذكر' : 'أنثى' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between" style="flex-direction: row-reverse;">
                                <strong>:تاريخ الميلاد</strong>
                                <span class="text-muted">{{ $user->birth_date ?? 'غير محدد' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between" style="flex-direction: row-reverse;">
                                <strong>:نبذة</strong>
                                <span class="text-muted">{{ $user->bio ?? 'لا توجد نبذة' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between" style="flex-direction: row-reverse;">
                                <strong>:تاريخ الانضمام</strong>
                                <span class="text-muted">
                                    {{ $user?->created_at?->format('d M Y') ?? 'لا توجد بيانات' }}
                                    <small>({{ $user?->created_at?->diffForHumans() }})</small>
                                </span>
                            </li>
                        </ul>


                    </div>
                </div>
            </div>
        </div>

        <!-- قسم الهدايا -->
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-gift fa-3x text-primary mb-3"></i>
                            <h3 class="card-title">الهدايا</h3>
                            <p class="card-text display-4">{{ $user->gifts_count ?? 0 }}</p>
                            <p class="text-muted">عدد الهدايا التي حصل عليها</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-coins fa-3x text-warning mb-3"></i>
                            <h3 class="card-title">عدد العملات</h3>
                            <p class="card-text display-4">{{ $user->coins ?? 0 }}</p>
                            <p class="text-muted">عدد العملات التي حصل عليها</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-newspaper fa-3x text-warning mb-3"></i>
                            <h3 class="card-title">إحصائيات المنشورات</h3>
                            <p class="card-text display-4">{{ $user->posts->count() ?? 0 }}</p>
                            <p class="text-muted">عدد المنشورات التي قام بنشرها</p>

                            <div class="row mt-3">
                                <div class="col-6">
                                    <i class="fas fa-comments text-info"></i>
                                    <p class="card-text"><strong>التعليقات:</strong>
                                        {{ $user->posts->sum('comments_count') ?? 0 }}</p>
                                </div>
                                <div class="col-6">
                                    <i class="fas fa-thumbs-up text-primary"></i>
                                    <p class="card-text"><strong>الإعجابات:</strong>
                                        {{ $user->posts->sum('likes_count') ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-envelope fa-3x text-success mb-3"></i>
                            <h3 class="card-title">عدد الرسائل المجهولة</h3>
                            <p class="card-text display-4">{{ $user->sentMessages->where('is_anonymous', 1)->count() }}</p>
                            <p class="text-muted">عدد الرسائل المجهولة</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- المتابعون والمتابعون -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-3">المتابعون ({{ $followersCount }})</h4>
                        @if ($user->followers->count() > 0)
                            <ul class="list-group">
                                @foreach ($user->followers->take(5) as $follower)
                                    <li class="list-group-item">
                                        {{ $follower->name }} ({{ $follower->email }})
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">لا يوجد متابعون.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-3">يتابع ({{ $followingCount }})</h4>
                        @if ($user->followings->count() > 0)
                            <ul class="list-group">
                                @foreach ($user->following->take(5) as $following)
                                    <li class="list-group-item">
                                        {{ $following->name }} ({{ $following->email }})
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">لا يوجد متابَعون.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-3 text-center">إحصائيات الهدايا</h4>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card text-center bg-primary text-white">
                                <div class="card-body">
                                    <h5>الهدايا المرسلة</h5>
                                    <h2>{{ $user->sent_gifts_count ?? 0 }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card text-center bg-success text-white">
                                <div class="card-body">
                                    <h5>الهدايا المستلمة</h5>
                                    <h2>{{ $user->received_gifts_count ?? 0 }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h4 class="mb-3 text-center">الهدايا التي حصل عليها المستخدم</h4>
                    @if ($user->gifts && $user->gifts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>اسم الهدية</th>
                                        <th>الوصف</th>
                                        <th>الكمية</th>
                                        <th>المرسل</th>
                                        <th>الحالة</th>
                                        <th>التاريخ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->gifts as $index => $gift)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $gift->title }}</td>
                                            <td>{{ $gift->description ?? 'لا يوجد وصف' }}</td>
                                            <td>{{ $gift->pivot->quantity }}</td>
                                            <td>
                                                @if ($gift->pivot->sender_id)
                                                    {{ \App\Models\User::find($gift->pivot->sender_id)->name ?? 'غير معروف' }}
                                                @else
                                                    <span class="text-muted">غير متوفر</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($gift->pivot->sender_id == $user->id)
                                                    <i class="fas fa-paper-plane text-primary" title="مرسل"></i>
                                                    <span class="text-primary">مرسل</span>
                                                @else
                                                    <i class="fas fa-gift text-success" title="مستلم"></i>
                                                    <span class="text-success">مستلم</span>
                                                @endif
                                            </td>
                                            <td>{{ $gift->pivot->created_at->format('d M Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">لا توجد هدايا حتى الآن.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>



@endsection

@extends('layouts.app') {{-- افترض أن هذا هو ملف اللي اوت الرئيسي لديك --}}

@section('content')
    <div class="container-fluid">
        {{-- عنوان الصفحة ومسار التنقل --}}
        <div class="row">
            <div class="col-12">
                <h1 class="h3 mb-0 text-gray-800">إدارة الألعاب</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home.dashboard') }}">لوحة التحكم</a></li>
                        <li class="breadcrumb-item active" aria-current="page">الألعاب</li>
                    </ol>
                </nav>
            </div>
        </div>

        @include('components.alerts') {{-- لتضمين رسائل النجاح والخطأ --}}

        {{-- إحصائيات الألعاب --}}
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <x-stats-card icon="fas fa-gamepad" title="إجمالي الألعاب" :value="$totalGames" color="primary" />
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <x-stats-card icon="fas fa-check-circle" title="الألعاب المفعلة" :value="$activeGamesCount" color="success" />
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <x-stats-card icon="fas fa-times-circle" title="الألعاب غير المفعلة" :value="$inactiveGamesCount" color="danger" />
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <x-stats-card icon="fas fa-star" title="أحدث لعبة" :value="$latestGame->name ?? 'لا يوجد'" color="warning" />
            </div>
        </div>

        {{-- بطاقة قائمة الألعاب --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">قائمة الألعاب</h6>
                <button class="btn btn-primary" data-toggle="modal" data-target="#createGameModal">
                    <i class="fas fa-plus"></i> إضافة لعبة
                </button>
            </div>
            <div class="card-body">
                {{-- تبويب الحالات --}}
                <ul class="nav nav-tabs mb-4">
                    <li class="nav-item">
                        <a class="nav-link {{ $selectedStatus === 'all' ? 'active' : '' }}"
                            href="{{ route('games.index') }}">الكل</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $selectedStatus === 'active' ? 'active' : '' }}"
                            href="{{ route('games.index', ['status' => 'active']) }}">مفعل</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $selectedStatus === 'inactive' ? 'active' : '' }}"
                            href="{{ route('games.index', ['status' => 'inactive']) }}">غير مفعل</a>
                    </li>
                </ul>

                {{-- نموذج البحث --}}
                <form action="{{ route('games.index') }}" method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="ابحث باسم اللعبة..."
                            value="{{ request('search') }}">
                        @if (request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> بحث</button>
                        </div>
                    </div>
                </form>

                {{-- جدول الألعاب --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>الصورة</th>
                                <th>الاسم</th>
                                <th>الترتيب</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($games as $game)
                                <tr>
                                    <td>
                                        <img src="{{ asset('storage/' . $game->image) }}" alt="{{ $game->name }}"
                                            class="rounded" width="80" height="80" style="object-fit: cover;">
                                    </td>
                                    <td>{{ $game->name }}</td>
                                    <td>{{ $game->position }}</td>
                                    <td>
                                        <span class="badge badge-{{ $game->is_active ? 'success' : 'danger' }}">
                                            {{ $game->is_active ? 'مفعل' : 'غير مفعل' }}
                                        </span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-circle btn-info" data-toggle="modal"
                                            data-target="#showGameModal{{ $game->id }}" title="عرض"><i
                                                class="fas fa-eye"></i></button>
                                        <button type="button" class="btn btn-sm btn-circle btn-primary" data-toggle="modal"
                                            data-target="#editGameModal{{ $game->id }}" title="تعديل"><i
                                                class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-sm btn-circle btn-danger" data-toggle="modal"
                                            data-target="#deleteGameModal{{ $game->id }}" title="حذف"><i
                                                class="fas fa-trash"></i></button>

                                        {{-- تضمين المودالات لكل لعبة --}}
                                        @include('dashboard.games.modals.show', ['game' => $game])
                                        @include('dashboard.games.modals.edit', ['game' => $game])
                                        @include('dashboard.games.modals.delete', ['game' => $game])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">لا توجد ألعاب تطابق هذا البحث.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- الترقيم --}}
                <div class="d-flex justify-content-center">
                    {{ $games->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- مودال إضافة لعبة (ثابت) --}}
    @include('dashboard.games.modals.create')
@endsection

@push('scripts')
    <script>
        // عرض اسم الملف المختار في حقول رفع الملفات
        $('.custom-file-input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });

        // تفعيل التولتيب (Tooltip)
        $('[data-toggle="tooltip"]').tooltip();
    </script>
@endpush

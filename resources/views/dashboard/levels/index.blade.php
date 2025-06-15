@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- عنوان الصفحة ومسار التنقل --}}
        <div class="row">
            <div class="col-12">
                <h1 class="h3 mb-0 text-gray-800">إدارة المستويات</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home.dashboard') }}">لوحة التحكم</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">المستويات</li>
                    </ol>
                </nav>
            </div>
        </div>

        @include('components.alerts')

        {{-- إحصائيات المستويات --}}
        <div class="row mb-4">
            {{-- إجمالي المستويات --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <x-stats-card icon="fas fa-layer-group" title="إجمالي المستويات" :value="$totalLevels" color="primary" />
            </div>
            {{-- المستويات النشطة --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <x-stats-card icon="fas fa-check-circle" title="المستويات النشطة" :value="$activeLevels" color="success" />
            </div>
            {{-- المستويات المعطلة --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <x-stats-card icon="fas fa-ban" title="المستويات المعطلة" :value="$inactiveLevels" color="danger" />
            </div>
            {{-- أعلى مستوى --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <x-stats-card icon="fas fa-trophy" title="أعلى مستوى" :value="$highestLevel" color="warning" />
            </div>
        </div>

        {{-- بطاقة قائمة المستويات --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">قائمة المستويات</h6>
                <button class="btn btn-primary" data-toggle="modal" data-target="#createLevelModal">
                    <i class="fas fa-plus"></i> إضافة مستوى
                </button>
            </div>
            <div class="card-body">
                {{-- تبويب حالة المستويات --}}
                <ul class="nav nav-tabs mb-4">
                    <li class="nav-item">
                        <a class="nav-link {{ $statusFilter === 'all' ? 'active' : '' }}"
                            href="{{ route('levels.index') }}">الكل</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $statusFilter === 'active' ? 'active' : '' }}"
                            href="{{ route('levels.index', ['status' => 'active']) }}">النشطة</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $statusFilter === 'inactive' ? 'active' : '' }}"
                            href="{{ route('levels.index', ['status' => 'inactive']) }}">المعطلة</a>
                    </li>
                </ul>

                {{-- نموذج البحث والتصفية --}}
                <form action="{{ route('levels.index') }}" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control"
                                    placeholder="ابحث باسم المستوى أو رقمه..." value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i> بحث
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select name="points_range" class="form-control" onchange="this.form.submit()">
                                <option value="">جميع النقاط</option>
                                <option value="0-100" {{ request('points_range') == '0-100' ? 'selected' : '' }}>0-100 نقطة
                                </option>
                                <option value="101-500" {{ request('points_range') == '101-500' ? 'selected' : '' }}>
                                    101-500 نقطة</option>
                                <option value="501-1000" {{ request('points_range') == '501-1000' ? 'selected' : '' }}>
                                    501-1000 نقطة</option>
                                <option value="1001+" {{ request('points_range') == '1001+' ? 'selected' : '' }}>1001+
                                    نقطة</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="sort" class="form-control" onchange="this.form.submit()">
                                <option value="level_number_asc"
                                    {{ request('sort') == 'level_number_asc' ? 'selected' : '' }}>ترتيب تصاعدي</option>
                                <option value="level_number_desc"
                                    {{ request('sort') == 'level_number_desc' ? 'selected' : '' }}>ترتيب تنازلي</option>
                                <option value="points_asc" {{ request('sort') == 'points_asc' ? 'selected' : '' }}>الأقل
                                    نقاطاً</option>
                                <option value="points_desc" {{ request('sort') == 'points_desc' ? 'selected' : '' }}>الأكثر
                                    نقاطاً</option>
                            </select>
                        </div>
                    </div>
                </form>

                {{-- جدول المستويات --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>رقم المستوى</th>
                                <th>الاسم</th>
                                <th>النقاط المطلوبة</th>
                                <th>الحالة</th>
                                <th>المظهر</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($levels as $level)
                                <tr>
                                    <td>
                                        <span class="badge badge-secondary" style="font-size: 1.1em;">
                                            {{ $level->level_number }}
                                        </span>
                                    </td>
                                    <td>
                                        <strong>{{ $level->name ?? 'بدون اسم' }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ number_format($level->points_required) }} نقطة
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $level->is_active ? 'success' : 'danger' }}">
                                            {{ $level->is_active ? 'نشط' : 'معطل' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($level->color || $level->icon)
                                            <div class="d-flex align-items-center">
                                                @if ($level->icon)
                                                    <i class="{{ $level->icon }} mr-2"
                                                        style="color: {{ $level->color ?? '#000' }}; font-size: 1.5em;"></i>
                                                @endif
                                                @if ($level->color)
                                                    <span class="color-preview"
                                                        style="display: inline-block; width: 20px; height: 20px; background-color: {{ $level->color }}; border: 1px solid #ddd;"></span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted">بدون مظهر</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{-- زر عرض --}}
                                        <button type="button" class="btn btn-sm btn-circle btn-info" data-toggle="modal"
                                            data-target="#showLevelModal{{ $level->id }}" title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        {{-- زر تعديل --}}
                                        <button type="button" class="btn btn-sm btn-circle btn-primary" data-toggle="modal"
                                            data-target="#editLevelModal{{ $level->id }}" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        {{-- زر حذف --}}
                                        <button type="button" class="btn btn-sm btn-circle btn-danger"
                                            data-toggle="modal" data-target="#deleteLevelModal{{ $level->id }}"
                                            title="حذف">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                        {{-- تضمين المودالات لكل مستوى --}}
                                        @include('dashboard.levels.modals.show', ['level' => $level])
                                        @include('dashboard.levels.modals.edit', ['level' => $level])
                                        @include('dashboard.levels.modals.delete', ['level' => $level])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">لا يوجد مستويات</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- الترقيم --}}
                <div class="d-flex justify-content-center">
                    {{ $levels->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- مودال إضافة مستوى (ثابت) --}}
    @include('dashboard.levels.modals.create')
@endsection

@push('styles')
    <style>
        .color-preview {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 1px solid #ddd;
        }

        .level-badge {
            font-size: 1.2em;
            padding: 8px 12px;
            border-radius: 10px;
        }
    </style>
@endpush

@push('scripts')
    {{-- عرض اسم الملف المختار في حقول upload --}}
    <script>
        $('.custom-file-input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });

        {{-- تفعيل التولتيب الافتراضي --}}
        $('[data-toggle="tooltip"]').tooltip();

        {{-- Color Picker --}}
        $(document).ready(function() {
            $('.color-picker').colorpicker({
                format: 'hex'
            });
        });
    </script>
@endpush

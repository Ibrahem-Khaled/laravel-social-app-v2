@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- عنوان الصفحة ومسار التنقل --}}
        <div class="row">
            <div class="col-12">
                <h1 class="h3 mb-0 text-gray-800">إدارة عروض بيع العملات</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home.dashboard') }}">لوحة التحكم</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">عروض بيع العملات</li>
                    </ol>
                </nav>
            </div>
        </div>

        @include('components.alerts')

        {{-- إحصائيات عروض البيع --}}
        <div class="row mb-4">
            {{-- إجمالي العروض --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    إجمالي العروض</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCoins }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-coins fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- العروض النشطة --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    العروض النشطة</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeCoins }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- عروض الموبايل --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    عروض الموبايل</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $mobileCoins }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-mobile-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- عروض الويب --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    عروض الويب</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $webCoins }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-desktop fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- بطاقة قائمة عروض البيع --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">قائمة عروض بيع العملات</h6>
                <button class="btn btn-primary" data-toggle="modal" data-target="#createCoinModal">
                    <i class="fas fa-plus"></i> إضافة عرض جديد
                </button>
            </div>
            <div class="card-body">
                {{-- تبويب المنصات --}}
                <ul class="nav nav-tabs mb-4">
                    <li class="nav-item">
                        <a class="nav-link {{ $selectedPlatform === 'all' ? 'active' : '' }}"
                            href="{{ route('sell-coins.index') }}">الكل</a>
                    </li>
                    @foreach ($platforms as $platform)
                        <li class="nav-item">
                            <a class="nav-link {{ $selectedPlatform === $platform ? 'active' : '' }}"
                                href="{{ route('sell-coins.index', ['platform' => $platform]) }}">
                                @php
                                    $platformNames = [
                                        'mobile' => 'موبايل',
                                        'web' => 'ويب',
                                    ];
                                @endphp
                                {{ $platformNames[$platform] ?? $platform }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                {{-- نموذج البحث --}}
                <form action="{{ route('sell-coins.index') }}" method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="ابحث بالمبلغ أو السعر..."
                            value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> بحث
                            </button>
                        </div>
                    </div>
                </form>

                {{-- جدول عروض البيع --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>الكمية</th>
                                <th>السعر</th>
                                <th>الأيقونة</th>
                                <th>الحالة</th>
                                <th>المنصة</th>
                                <th>تاريخ الإنشاء</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($coins as $coin)
                                <tr>
                                    <td>{{ number_format($coin->amount) }}</td>
                                    <td>{{ number_format($coin->price, 2) }}</td>
                                    <td>
                                        @if ($coin->icon)
                                            <img src="{{ asset('storage/' . $coin->icon) }}" alt="Coin Icon"
                                                width="40">
                                        @else
                                            <i class="fas fa-coins fa-2x text-gray-300"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $coin->is_active ? 'success' : 'danger' }}">
                                            {{ $coin->is_active ? 'نشط' : 'غير نشط' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $coin->platform === 'mobile' ? 'info' : 'primary' }}">
                                            {{ $platformNames[$coin->platform] ?? $coin->platform }}
                                        </span>
                                    </td>
                                    <td>{{ $coin->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        {{-- زر عرض --}}
                                        <button type="button" class="btn btn-sm btn-circle btn-info" data-toggle="modal"
                                            data-target="#showCoinModal{{ $coin->id }}" title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        {{-- زر تعديل --}}
                                        <button type="button" class="btn btn-sm btn-circle btn-primary" data-toggle="modal"
                                            data-target="#editCoinModal{{ $coin->id }}" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        {{-- زر حذف --}}
                                        <button type="button" class="btn btn-sm btn-circle btn-danger" data-toggle="modal"
                                            data-target="#deleteCoinModal{{ $coin->id }}" title="حذف">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                        {{-- تضمين المودالات لكل عرض --}}
                                        @include('dashboard.sell-coins.modals.show', ['coin' => $coin])
                                        @include('dashboard.sell-coins.modals.edit', ['coin' => $coin])
                                        @include('dashboard.sell-coins.modals.delete', ['coin' => $coin])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">لا توجد عروض بيع عملات</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- الترقيم --}}
                <div class="d-flex justify-content-center">
                    {{ $coins->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- مودال إضافة عرض جديد --}}
    <div class="modal fade" id="createCoinModal" tabindex="-1" role="dialog" aria-labelledby="createCoinModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCoinModalLabel">إضافة عرض بيع عملات جديد</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('sell-coins.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="amount">الكمية</label>
                            <input type="number" class="form-control" id="amount" name="amount" required
                                min="1">
                        </div>

                        <div class="form-group">
                            <label for="price">السعر</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price"
                                required min="0">
                        </div>

                        <div class="form-group">
                            <label for="icon">الأيقونة (اختياري)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="icon" name="icon">
                                <label class="custom-file-label" for="icon">اختر ملف</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="platform">المنصة</label>
                            <select class="form-control" id="platform" name="platform" required>
                                <option value="mobile">موبايل</option>
                                <option value="web">ويب</option>
                            </select>
                        </div>

                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" checked>
                            <label class="form-check-label" for="is_active">نشط</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // عرض اسم الملف المختار
        $('.custom-file-input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });

        // تفعيل التولتيب
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>
@endpush

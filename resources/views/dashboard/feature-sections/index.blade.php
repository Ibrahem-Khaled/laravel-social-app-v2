@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- Page Title & Breadcrumb --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">إدارة السكاشن المميزة</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">لوحة التحكم</a></li>
                    <li class="breadcrumb-item active" aria-current="page">السكاشن المميزة</li>
                </ol>
            </nav>
        </div>

        @include('components.alerts')

        {{-- Stats Cards --}}
        <div class="row mb-4">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">إجمالي السكاشن</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalSections }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-puzzle-piece fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">إجمالي المميزات</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalFeatures }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sections Table Card --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">قائمة السكاشن</h6>
                <button class="btn btn-primary" data-toggle="modal" data-target="#createSectionModal">
                    <i class="fas fa-plus fa-sm"></i> إضافة سكشن جديد
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th>الصورة</th>
                                <th>المعرف (Slug)</th>
                                <th>العنوان</th>
                                <th>عدد المميزات</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sections as $section)
                                <tr>
                                    <td>
                                        <img src="{{ asset('storage/' . $section->image_path) }}"
                                            alt="{{ $section->image_alt }}" class="img-thumbnail" width="80">
                                    </td>
                                    <td><span class="badge badge-secondary">{{ $section->slug }}</span></td>
                                    <td>{{ $section->highlighted_title }}</td>
                                    <td><span class="badge badge-info">{{ $section->items_count }}</span></td>
                                    <td>
                                        <button class="btn btn-info btn-circle btn-sm" data-toggle="modal"
                                            data-target="#showSectionModal{{ $section->id }}" title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-primary btn-circle btn-sm" data-toggle="modal"
                                            data-target="#editSectionModal{{ $section->id }}" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-circle btn-sm" data-toggle="modal"
                                            data-target="#deleteSectionModal{{ $section->id }}" title="حذف">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @include('dashboard.feature-sections.modals._show')
                                @include('dashboard.feature-sections.modals._edit')
                                @include('dashboard.feature-sections.modals._delete')
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">لا توجد سكاشن لعرضها.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $sections->links() }}
                </div>
            </div>
        </div>
    </div>

    @include('dashboard.feature-sections.modals._create')
@endsection

@push('scripts')
    <script>
        // Handle dynamic adding/removing of feature items in modals
        document.addEventListener('click', function(e) {
            if (e.target.matches('.add-item-btn')) {
                const container = e.target.previousElementSibling;
                const newItem = `
                <div class="input-group mb-2">
                    <input type="text" name="items[]" class="form-control" placeholder="نص الميزة" required>
                    <div class="input-group-append">
                        <button class="btn btn-outline-danger remove-item-btn" type="button">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>`;
                container.insertAdjacentHTML('beforeend', newItem);
            }

            if (e.target.matches('.remove-item-btn') || e.target.closest('.remove-item-btn')) {
                const item = e.target.closest('.input-group');
                item.remove();
            }
        });

        // Preview uploaded image in modals
        function previewImage(event) {
            const reader = new FileReader();
            const output = event.target.closest('.form-group').querySelector('.image-preview');
            reader.onload = function() {
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        // Display file name in custom file input
        $('.custom-file-input').on('change', function(event) {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
            previewImage(event);
        });
    </script>
@endpush

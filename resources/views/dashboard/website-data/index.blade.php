@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">إدارة بيانات الموقع</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('website-data.store-or-update') }}"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <!-- العمود الأول -->
                                <div class="col-md-6">
                                    <!-- حقل الاسم -->
                                    <div class="mb-3">
                                        <label for="name" class="form-label">اسم الموقع *</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name"
                                            value="{{ old('name', $websiteData->name ?? '') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- حقل البريد الإلكتروني -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label">البريد الإلكتروني *</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email"
                                            value="{{ old('email', $websiteData->email ?? '') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- حقل الهاتف -->
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">الهاتف</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                            id="phone" name="phone"
                                            value="{{ old('phone', $websiteData->phone ?? '') }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- حقل صورة الموقع -->
                                    <div class="mb-3">
                                        <label for="avatar" class="form-label">رابط الصورة</label>
                                        <input type="file" class="form-control @error('avatar') is-invalid @enderror"
                                            id="avatar" name="avatar"
                                            value="{{ old('avatar', $websiteData->avatar ?? '') }}">
                                        @error('avatar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @if (isset($websiteData->avatar) && $websiteData->avatar)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $websiteData->avatar) }}" alt="صورة الموقع"
                                                    style="max-height: 100px;">
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- العمود الثاني -->
                                <div class="col-md-6">
                                    <!-- حقل اللغة -->
                                    <div class="mb-3">
                                        <label for="language" class="form-label">اللغة *</label>
                                        <input type="text" class="form-control @error('language') is-invalid @enderror"
                                            id="language" name="language"
                                            value="{{ old('language', $websiteData->language ?? 'ar') }}" required>
                                        @error('language')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- حقل العنوان -->
                                    <div class="mb-3">
                                        <label for="address" class="form-label">العنوان</label>
                                        <input type="text" class="form-control @error('address') is-invalid @enderror"
                                            id="address" name="address"
                                            value="{{ old('address', $websiteData->address ?? '') }}">
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- حقل البلد -->
                                    <div class="mb-3">
                                        <label for="country" class="form-label">البلد</label>
                                        <input type="text" class="form-control @error('country') is-invalid @enderror"
                                            id="country" name="country"
                                            value="{{ old('country', $websiteData->country ?? '') }}">
                                        @error('country')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- حقل تاريخ التأسيس -->
                                    <div class="mb-3">
                                        <label for="birth_date" class="form-label">تاريخ التأسيس</label>
                                        <input type="date" class="form-control @error('birth_date') is-invalid @enderror"
                                            id="birth_date" name="birth_date"
                                            value="{{ old('birth_date', $websiteData->birth_date ?? '') }}">
                                        @error('birth_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- حقل نبذة عن الموقع -->
                            <div class="mb-3">
                                <label for="bio" class="form-label">نبذة عن الموقع</label>
                                <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="3">{{ old('bio', $websiteData->bio ?? '') }}</textarea>
                                @error('bio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- حقل روابط التواصل الاجتماعي -->
                            <div class="mb-3">
                                <label class="form-label">روابط التواصل الاجتماعي</label>

                                <div id="socialLinksContainer">
                                    @php
                                        $socialLinks = json_decode($websiteData->social_links ?? '{}', true);
                                    @endphp

                                    @if (!empty($socialLinks))
                                        @foreach ($socialLinks as $key => $value)
                                            <div class="row g-2 mb-2 social-link-item">
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="social_keys[]"
                                                        placeholder="اسم المنصة (مثال: فيسبوك)"
                                                        value="{{ $key }}" required>
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="url" class="form-control" name="social_values[]"
                                                        placeholder="رابط المنصة" value="{{ $value }}" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-danger btn-sm remove-link">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="row g-2 mb-2 social-link-item">
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" name="social_keys[]"
                                                    placeholder="اسم المنصة (مثال: فيسبوك)" required>
                                            </div>
                                            <div class="col-md-5">
                                                <input type="url" class="form-control" name="social_values[]"
                                                    placeholder="رابط المنصة" required>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-danger btn-sm remove-link">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <button type="button" id="addSocialLink" class="btn btn-primary btn-sm mt-2">
                                    <i class="fas fa-plus"></i> إضافة رابط جديد
                                </button>

                                <!-- ستحتاج هذا الحقل المخفي لتخزين البيانات النهائية -->
                                <input type="hidden" name="social_links" id="socialLinksJson"
                                    value="{{ $websiteData->social_links ?? '{}' }}">
                            </div>

                            <!-- زر الحفظ -->
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i>
                                    {{ isset($websiteData->id) ? 'حفظ التغييرات' : 'حفظ البيانات' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('socialLinksContainer');
            const addButton = document.getElementById('addSocialLink');
            const jsonInput = document.getElementById('socialLinksJson');

            // إضافة رابط جديد
            addButton.addEventListener('click', function() {
                const newItem = document.createElement('div');
                newItem.className = 'row g-2 mb-2 social-link-item';
                newItem.innerHTML = `
            <div class="col-md-5">
                <input type="text" class="form-control" name="social_keys[]"
                       placeholder="اسم المنصة (مثال: فيسبوك)" required>
            </div>
            <div class="col-md-5">
                <input type="url" class="form-control" name="social_values[]"
                       placeholder="رابط المنصة" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm remove-link">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
                container.appendChild(newItem);

                // إضافة حدث للحذف
                newItem.querySelector('.remove-link').addEventListener('click', function() {
                    container.removeChild(newItem);
                    updateJsonInput();
                });

                // تحديث عند التعديل
                newItem.querySelectorAll('input').forEach(input => {
                    input.addEventListener('input', updateJsonInput);
                });
            });

            // حذف عنصر موجود
            document.querySelectorAll('.remove-link').forEach(button => {
                button.addEventListener('click', function() {
                    const item = this.closest('.social-link-item');
                    container.removeChild(item);
                    updateJsonInput();
                });
            });

            // تحديث الـ JSON عند التعديل
            document.querySelectorAll('#socialLinksContainer input').forEach(input => {
                input.addEventListener('input', updateJsonInput);
            });

            // دالة لتحديث الحقل المخفي
            function updateJsonInput() {
                const keys = document.querySelectorAll('input[name="social_keys[]"]');
                const values = document.querySelectorAll('input[name="social_values[]"]');
                const data = {};

                keys.forEach((keyInput, index) => {
                    if (keyInput.value.trim() && values[index].value.trim()) {
                        data[keyInput.value.trim()] = values[index].value.trim();
                    }
                });

                jsonInput.value = JSON.stringify(data);
            }
        });
    </script>
@endsection

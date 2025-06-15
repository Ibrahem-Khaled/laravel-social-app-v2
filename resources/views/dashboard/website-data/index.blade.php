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
                                <label for="social_links" class="form-label">روابط التواصل الاجتماعي (JSON)</label>
                                <textarea class="form-control @error('social_links') is-invalid @enderror" id="social_links" name="social_links"
                                    rows="2">{{ old('social_links', $websiteData->social_links ?? '') }}</textarea>
                                @error('social_links')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- حقل الإعدادات -->
                            {{-- <div class="mb-3">
                                <label for="settings" class="form-label">الإعدادات (JSON)</label>
                                <textarea class="form-control @error('settings') is-invalid @enderror" id="settings" name="settings"
                                    rows="2">{{ old('settings', $websiteData->settings ?? '') }}</textarea>
                                @error('settings')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}

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
@endsection

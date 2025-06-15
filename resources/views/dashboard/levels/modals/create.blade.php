<div class="modal fade" id="createLevelModal" tabindex="-1" role="dialog" aria-labelledby="createLevelModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createLevelModalLabel">إضافة مستوى جديد</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('levels.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="level_number">رقم المستوى <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="level_number" name="level_number"
                                    required min="1" value="{{ old('level_number') }}">
                                @error('level_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">اسم المستوى (اختياري)</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name') }}" placeholder="مثل: مبتدئ، محترف، إلخ">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="points_required">النقاط المطلوبة <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="points_required" name="points_required"
                                    required min="0" value="{{ old('points_required', 0) }}">
                                @error('points_required')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="is_active">حالة المستوى</label>
                                <select class="form-control" id="is_active" name="is_active">
                                    <option value="1" selected>نشط</option>
                                    <option value="0">معطل</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="color">لون المستوى (اختياري)</label>
                                <div class="input-group color-picker">
                                    <input type="text" class="form-control" id="color" name="color"
                                        value="{{ old('color') }}" placeholder="#FFD700">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-square"
                                                style="color: {{ old('color', '#FFD700') }}"></i></span>
                                    </div>
                                </div>
                                <small class="form-text text-muted">اختر لوناً يميز هذا المستوى</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="icon">أيقونة المستوى (اختياري)</label>
                                <select class="form-control select2" id="icon" name="icon">
                                    <option value="">بدون أيقونة</option>
                                    <option value="fas fa-star" {{ old('icon') == 'fas fa-star' ? 'selected' : '' }}>
                                        نجمة</option>
                                    <option value="fas fa-crown" {{ old('icon') == 'fas fa-crown' ? 'selected' : '' }}>
                                        تاج</option>
                                    <option value="fas fa-trophy"
                                        {{ old('icon') == 'fas fa-trophy' ? 'selected' : '' }}>كأس</option>
                                    <option value="fas fa-medal" {{ old('icon') == 'fas fa-medal' ? 'selected' : '' }}>
                                        ميدالية</option>
                                    <option value="fas fa-gem" {{ old('icon') == 'fas fa-gem' ? 'selected' : '' }}>
                                        ألماسة</option>
                                    <option value="fas fa-shield-alt"
                                        {{ old('icon') == 'fas fa-shield-alt' ? 'selected' : '' }}>درع</option>
                                </select>
                                <small class="form-text text-muted">اختر أيقونة من مكتبة Font Awesome</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">وصف المستوى (اختياري)</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ المستوى</button>
                </div>
            </form>
        </div>
    </div>
</div>

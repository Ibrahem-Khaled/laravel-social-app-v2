<div class="modal fade" id="editLevelModal{{ $level->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editLevelModalLabel{{ $level->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLevelModalLabel{{ $level->id }}">تعديل المستوى</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('levels.update', $level->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_level_number{{ $level->id }}">رقم المستوى <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_level_number{{ $level->id }}"
                                    name="level_number" required min="1" value="{{ $level->level_number }}">
                                @error('level_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_name{{ $level->id }}">اسم المستوى (اختياري)</label>
                                <input type="text" class="form-control" id="edit_name{{ $level->id }}"
                                    name="name" value="{{ $level->name }}" placeholder="مثل: مبتدئ، محترف، إلخ">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_points_required{{ $level->id }}">النقاط المطلوبة <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_points_required{{ $level->id }}"
                                    name="points_required" required min="0"
                                    value="{{ $level->points_required }}">
                                @error('points_required')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_is_active{{ $level->id }}">حالة المستوى</label>
                                <select class="form-control" id="edit_is_active{{ $level->id }}" name="is_active">
                                    <option value="1" {{ $level->is_active ? 'selected' : '' }}>نشط</option>
                                    <option value="0" {{ !$level->is_active ? 'selected' : '' }}>معطل</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_color{{ $level->id }}">لون المستوى (اختياري)</label>
                                <div class="input-group color-picker">
                                    <input type="text" class="form-control" id="edit_color{{ $level->id }}"
                                        name="color" value="{{ $level->color }}" placeholder="#FFD700">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-square"
                                                style="color: {{ $level->color ?? '#FFD700' }}"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_icon{{ $level->id }}">أيقونة المستوى (اختياري)</label>
                                <select class="form-control select2" id="edit_icon{{ $level->id }}" name="icon">
                                    <option value="">بدون أيقونة</option>
                                    <option value="fas fa-star" {{ $level->icon == 'fas fa-star' ? 'selected' : '' }}>
                                        نجمة</option>
                                    <option value="fas fa-crown"
                                        {{ $level->icon == 'fas fa-crown' ? 'selected' : '' }}>تاج</option>
                                    <option value="fas fa-trophy"
                                        {{ $level->icon == 'fas fa-trophy' ? 'selected' : '' }}>كأس</option>
                                    <option value="fas fa-medal"
                                        {{ $level->icon == 'fas fa-medal' ? 'selected' : '' }}>ميدالية</option>
                                    <option value="fas fa-gem" {{ $level->icon == 'fas fa-gem' ? 'selected' : '' }}>
                                        ألماسة</option>
                                    <option value="fas fa-shield-alt"
                                        {{ $level->icon == 'fas fa-shield-alt' ? 'selected' : '' }}>درع</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="edit_description{{ $level->id }}">وصف المستوى (اختياري)</label>
                        <textarea class="form-control" id="edit_description{{ $level->id }}" name="description" rows="3">{{ $level->description }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                </div>
            </form>
        </div>
    </div>
</div>

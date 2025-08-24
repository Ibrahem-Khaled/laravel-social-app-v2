<!-- Edit Section Modal -->
<div class="modal fade" id="editSectionModal{{ $section->id }}" tabindex="-1" role="dialog" aria-labelledby="editSectionModalLabel{{ $section->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSectionModalLabel{{ $section->id }}">تعديل السكشن: {{ $section->highlighted_title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('feature-sections.update', $section->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="slug{{ $section->id }}">المعرف (Slug)</label>
                        <input type="text" class="form-control" id="slug{{ $section->id }}" name="slug" value="{{ old('slug', $section->slug) }}" required>
                    </div>
                     <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>النص قبل التمييز</label>
                                <input type="text" class="form-control" name="title_before_highlight" value="{{ old('title_before_highlight', $section->title_before_highlight) }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>النص المميز</label>
                                <input type="text" class="form-control" name="highlighted_title" value="{{ old('highlighted_title', $section->highlighted_title) }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                             <div class="form-group">
                                <label>النص بعد التمييز</label>
                                <input type="text" class="form-control" name="title_after_highlight" value="{{ old('title_after_highlight', $section->title_after_highlight) }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>الوصف</label>
                        <textarea class="form-control" name="description" rows="3" required>{{ old('description', $section->description) }}</textarea>
                    </div>
                     <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>نص الزر</label>
                                <input type="text" class="form-control" name="button_text" value="{{ old('button_text', $section->button_text) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                             <div class="form-group">
                                <label>رابط الزر</label>
                                <input type="text" class="form-control" name="button_url" value="{{ old('button_url', $section->button_url) }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>تغيير صورة السكشن (اختياري)</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="image_path">
                            <label class="custom-file-label">اختر صورة جديدة...</label>
                        </div>
                        <img src="{{ asset('storage/' . $section->image_path) }}" class="mt-2 image-preview" style="max-width: 100px; border-radius: 5px;">
                    </div>
                     <div class="form-group">
                        <label>النص البديل للصورة (SEO)</label>
                        <input type="text" class="form-control" name="image_alt" value="{{ old('image_alt', $section->image_alt) }}">
                    </div>
                    <hr>
                    <h6>قائمة المميزات</h6>
                    <div class="items-container">
                        @foreach($section->items as $item)
                        <div class="input-group mb-2">
                            <input type="text" name="items[]" class="form-control" placeholder="نص الميزة" value="{{ $item->text }}" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-danger remove-item-btn" type="button">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-outline-success btn-sm add-item-btn mt-2">
                        <i class="fas fa-plus"></i> إضافة ميزة أخرى
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-primary">تحديث</button>
                </div>
            </form>
        </div>
    </div>
</div>

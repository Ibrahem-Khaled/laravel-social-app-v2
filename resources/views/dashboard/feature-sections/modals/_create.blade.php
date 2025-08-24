<!-- Create Section Modal -->
<div class="modal fade" id="createSectionModal" tabindex="-1" role="dialog" aria-labelledby="createSectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createSectionModalLabel">إضافة سكشن جديد</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('feature-sections.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="slug">المعرف (Slug) - (يستخدم في الرابط، حروف إنجليزية بدون مسافات)</label>
                        <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') }}" required>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="title_before_highlight">النص قبل التمييز</label>
                                <input type="text" class="form-control" name="title_before_highlight" value="{{ old('title_before_highlight') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="highlighted_title">النص المميز</label>
                                <input type="text" class="form-control" name="highlighted_title" value="{{ old('highlighted_title') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                             <div class="form-group">
                                <label for="title_after_highlight">النص بعد التمييز</label>
                                <input type="text" class="form-control" name="title_after_highlight" value="{{ old('title_after_highlight') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">الوصف</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                    </div>
                     <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="button_text">نص الزر</label>
                                <input type="text" class="form-control" name="button_text" value="{{ old('button_text') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                             <div class="form-group">
                                <label for="button_url">رابط الزر</label>
                                <input type="text" class="form-control" name="button_url" value="{{ old('button_url') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>صورة السكشن</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image_path_create" name="image_path" required>
                            <label class="custom-file-label" for="image_path_create">اختر صورة...</label>
                        </div>
                        <img src="#" class="mt-2 image-preview" style="display:none; max-width: 100px; border-radius: 5px;">
                    </div>
                     <div class="form-group">
                        <label for="image_alt">النص البديل للصورة (SEO)</label>
                        <input type="text" class="form-control" name="image_alt" value="{{ old('image_alt') }}">
                    </div>
                    <hr>
                    <h6>قائمة المميزات</h6>
                    <div id="items-container-create">
                        <div class="input-group mb-2">
                            <input type="text" name="items[]" class="form-control" placeholder="نص الميزة" required>
                             <div class="input-group-append">
                                <button class="btn btn-outline-danger remove-item-btn" type="button" disabled><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-success btn-sm add-item-btn mt-2">
                        <i class="fas fa-plus"></i> إضافة ميزة أخرى
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-primary">حفظ السكشن</button>
                </div>
            </form>
        </div>
    </div>
</div>

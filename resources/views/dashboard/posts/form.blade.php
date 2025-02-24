<form action="{{ $post ? route('posts.update', $post->id) : route('posts.store') }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    @if ($post)
        @method('PUT')
    @endif
    <div class="modal-header">
        <h5 class="modal-title">{{ $post ? 'تعديل المنشور' : 'إضافة منشور جديد' }}</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="user_id" class="form-label">المستخدم</label>
            <select name="user_id" class="form-control" required>
                @foreach (\App\Models\User::all() as $user)
                    <option value="{{ $user->id }}" {{ $post && $post->user_id == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">المحتوى</label>
            <textarea name="content" class="form-control">{{ $post->content ?? '' }}</textarea>
        </div>

        <!-- حقل تحميل الصور -->
        <div class="mb-3">
            <label for="images" class="form-label">الصور (يمكن اختيار أكثر من صورة)</label>
            <input type="file" name="images[]" class="form-control" multiple accept="image/*"
                {{ !$post ? '' : '' }}>
            <small class="text-muted">الحد الأقصى لحجم الصورة: 2MB</small>
        </div>

        <!-- عرض الصور الحالية (في حالة التعديل) -->
        @if ($post && $post->images)
            <div class="mb-3">
                <label class="form-label">الصور الحالية:</label>
                <div class="d-flex flex-wrap gap-2">
                    @foreach (json_decode($post->images) as $image)
                        <div class="position-relative">
                            <img src="{{ asset('storage/' . $image) }}" alt="صورة المنشور" class="img-thumbnail"
                                style="width: 100px; height: 100px; object-fit: cover">
                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0"
                                onclick="deleteImage(this, '{{ $image }}')">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mb-3">
            <label for="status" class="form-label">الحالة</label>
            <select name="status" class="form-control" required>
                <option value="active" {{ $post && $post->status == 'active' ? 'selected' : '' }}>نشط</option>
                <option value="inactive" {{ $post && $post->status == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                <option value="banned" {{ $post && $post->status == 'banned' ? 'selected' : '' }}>محظور</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">{{ $post ? 'حفظ التعديلات' : 'إضافة' }}</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
    </div>
</form>

<!-- إضافة script لإدارة حذف الصور -->
<script>
    function deleteImage(button, imageName) {
        if (confirm('هل أنت متأكد من حذف هذه الصورة؟')) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'deleted_images[]';
            input.value = imageName;
            button.parentElement.appendChild(input);
            button.parentElement.remove();
        }
    }
</script>

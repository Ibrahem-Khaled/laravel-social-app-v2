<form action="{{ $post ? route('posts.update', $post->id) : route('posts.store') }}" method="POST">
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
        <div class="mb-3">
            <label for="media" class="form-label">الوسائط</label>
            <input type="text" name="media" class="form-control" value="{{ $post->media ?? '' }}">
        </div>
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

<form action="{{ $gift ? route('gifts.update', $gift->id) : route('gifts.store') }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    @if ($gift)
        @method('PUT')
    @endif
    <div class="modal-header">
        <h5 class="modal-title">{{ $gift ? 'تعديل بيانات الهدية' : 'إضافة هدية جديدة' }}</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="title" class="form-label">العنوان</label>
            <input type="text" name="title" class="form-control" value="{{ $gift->title ?? '' }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">الوصف</label>
            <textarea name="description" class="form-control">{{ $gift->description ?? '' }}</textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">الصورة</label>
            <input type="file" name="image" class="form-control">
            @if ($gift && $gift->image)
                <img src="{{ asset('storage/' . $gift->image) }}" alt="gift image" class="img-fluid mt-2"
                    width="150">
            @endif
        </div>
        <div class="mb-3">
            <label for="is_animated" class="form-label">الملف المتحرك</label>
            <input type="file" name="is_animated" class="form-control">
            @if ($gift && $gift->is_animated)
                <video class="mt-2" width="150" controls>
                    <source src="{{ asset('storage/' . $gift->is_animated) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            @endif
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">السعر (بالنقاط)</label>
            <input type="number" name="price" class="form-control" value="{{ $gift->price ?? '' }}" required>
        </div>
        <div class="mb-3">
            <label for="is_active" class="form-label">الحالة</label>
            <select name="is_active" class="form-control">
                <option value="1" {{ $gift && $gift->is_active ? 'selected' : '' }}>نشطة</option>
                <option value="0" {{ $gift && !$gift->is_active ? 'selected' : '' }}>غير نشطة</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">{{ $gift ? 'حفظ التعديلات' : 'إضافة' }}</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
    </div>
</form>

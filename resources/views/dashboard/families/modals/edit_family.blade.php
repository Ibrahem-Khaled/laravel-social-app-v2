<div class="modal fade" id="editFamilyModal{{ $family->id }}" tabindex="-1" role="dialog" aria-labelledby="editFamilyModalLabel{{ $family->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFamilyModalLabel{{ $family->id }}">تعديل العائلة: {{ $family->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('families.update', $family->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user_id">المستخدم</label>
                        <select name="user_id" id="user_id" class="form-control" required>
                            <option value="">اختر المستخدم</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ $user->id == $family->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">اسم العائلة</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $family->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="description">الوصف</label>
                        <textarea name="description" id="description" class="form-control">{{ $family->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">الصورة</label>
                        <input type="file" name="image" id="image" class="form-control">
                        @if ($family->image)
                            <img src="{{ asset('storage/' . $family->image) }}" alt="{{ $family->name }}" width="100" class="mt-2">
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                </div>
            </form>
        </div>
    </div>
</div>
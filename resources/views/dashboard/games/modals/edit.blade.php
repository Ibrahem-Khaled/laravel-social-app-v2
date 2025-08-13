<div class="modal fade" id="editGameModal{{ $game->id }}" tabindex="-1" role="dialog" aria-labelledby="editGameModalLabel{{ $game->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editGameModalLabel{{ $game->id }}">تعديل اللعبة: {{ $game->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('games.update', $game->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">اسم اللعبة</label>
                        <input type="text" name="name" class="form-control" value="{{ $game->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="url">رابط اللعبة</label>
                        <input type="url" name="url" class="form-control" value="{{ $game->url }}" required>
                    </div>
                     <div class="form-group">
                        <label>تغيير الصورة (اختياري)</label>
                        <div class="custom-file">
                            <input type="file" name="image" class="custom-file-input" id="edit-image-{{ $game->id }}">
                            <label class="custom-file-label" for="edit-image-{{ $game->id }}">اختر صورة جديدة...</label>
                        </div>
                         <img src="{{ asset('storage/' . $game->image) }}" class="img-thumbnail mt-2" width="100" />
                    </div>
                    <div class="form-group">
                        <label for="position">الترتيب</label>
                        <input type="number" name="position" class="form-control" value="{{ $game->position }}" required>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_active_edit_{{ $game->id }}" name="is_active" value="1" {{ $game->is_active ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_active_edit_{{ $game->id }}">تفعيل اللعبة</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-primary">تحديث</button>
                </div>
            </form>
        </div>
    </div>
</div>

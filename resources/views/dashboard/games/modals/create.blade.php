<div class="modal fade" id="createGameModal" tabindex="-1" role="dialog" aria-labelledby="createGameModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createGameModalLabel">إضافة لعبة جديدة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('games.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">اسم اللعبة</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="url">رابط اللعبة</label>
                        <input type="url" name="url" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>صورة اللعبة</label>
                        <div class="custom-file">
                            <input type="file" name="image" class="custom-file-input" id="create-image" required>
                            <label class="custom-file-label" for="create-image">اختر صورة...</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="position">الترتيب</label>
                        <input type="number" name="position" class="form-control" value="0" required>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_active_create" name="is_active"
                                value="1" checked>
                            <label class="custom-control-label" for="is_active_create">تفعيل اللعبة</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>

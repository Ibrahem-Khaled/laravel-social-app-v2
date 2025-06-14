<div class="modal-header">
    <h5 class="modal-title" id="createStreamModalLabel">إنشاء بث جديد</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form action="{{ route('live-streamings.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
        <div class="form-group">
            <label for="title">عنوان البث</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="form-group">
            <label for="description">وصف البث</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="type">نوع البث</label>
                    <select class="form-control" id="type" name="type" required>
                        <option value="live">بث فيديو</option>
                        <option value="audio_room">غرفة صوتية</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="agency_id">الوكالة (اختياري)</label>
                    <select class="form-control" id="agency_id" name="agency_id">
                        <option value="">اختر وكالة</option>
                        @foreach ($agencies as $agency)
                            <option value="{{ $agency->id }}">{{ $agency->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="scheduled_at">موعد البث (اختياري)</label>
                    <input type="text" class="form-control datetimepicker" id="scheduled_at" name="scheduled_at">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="password">كلمة المرور (اختياري)</label>
                    <input type="text" class="form-control" id="password" name="password">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="thumbnail">صورة مصغرة</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="thumbnail" name="thumbnail">
                <label class="custom-file-label" for="thumbnail">اختر صورة</label>
            </div>
        </div>

        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="status" name="status" checked>
            <label class="form-check-label" for="status">بث نشط</label>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
        <button type="submit" class="btn btn-primary">حفظ البث</button>
    </div>
</form>

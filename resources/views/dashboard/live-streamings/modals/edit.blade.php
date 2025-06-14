<div class="modal-header">
    <h5 class="modal-title" id="editStreamModalLabel{{ $stream->id }}">تعديل البث</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form action="{{ route('live-streamings.update', $stream->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div class="form-group">
            <label for="title">عنوان البث</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $stream->title }}"
                required>
        </div>

        <div class="form-group">
            <label for="description">وصف البث</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ $stream->description }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="type">نوع البث</label>
                    <select class="form-control" id="type" name="type" required>
                        <option value="live" {{ $stream->type == 'live' ? 'selected' : '' }}>بث فيديو</option>
                        <option value="audio_room" {{ $stream->type == 'audio_room' ? 'selected' : '' }}>غرفة صوتية
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="agency_id">الوكالة (اختياري)</label>
                    <select class="form-control" id="agency_id" name="agency_id">
                        <option value="">اختر وكالة</option>
                        @foreach ($agencies as $agency)
                            <option value="{{ $agency->id }}"
                                {{ $stream->agency_id == $agency->id ? 'selected' : '' }}>
                                {{ $agency->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="scheduled_at">موعد البث (اختياري)</label>
                    <input type="text" class="form-control datetimepicker" id="scheduled_at" name="scheduled_at"
                        value="{{ $stream->scheduled_at ? $stream->scheduled_at->format('Y-m-d H:i') : '' }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="password">كلمة المرور (اختياري)</label>
                    <input type="text" class="form-control" id="password" name="password"
                        value="{{ $stream->password }}">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="thumbnail">صورة مصغرة</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="thumbnail" name="thumbnail">
                <label class="custom-file-label" for="thumbnail">
                    {{ $stream->thumbnail ? basename($stream->thumbnail) : 'اختر صورة' }}
                </label>
            </div>
            @if ($stream->thumbnail)
                <small class="form-text text-muted">
                    الصورة الحالية:
                    <a href="{{ asset('storage/' . $stream->thumbnail) }}" target="_blank">عرض</a>
                </small>
            @endif
        </div>

        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="status" name="status"
                {{ $stream->status ? 'checked' : '' }}>
            <label class="form-check-label" for="status">بث نشط</label>
        </div>

        <div class="form-group">
            <label for="likes">عدد الإعجابات</label>
            <input type="number" class="form-control" id="likes" name="likes" value="{{ $stream->likes }}">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
        <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
    </div>
</form>

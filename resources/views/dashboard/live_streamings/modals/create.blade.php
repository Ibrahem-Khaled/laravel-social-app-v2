<div class="modal fade" id="createLiveStreamingModal" tabindex="-1" role="dialog"
     aria-labelledby="createLiveStreamingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createLiveStreamingModalLabel">إضافة بث مباشر جديد</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('live-streamings.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">العنوان</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="description">الوصف</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="user_id">المستخدم</label>
                            <select class="form-control" id="user_id" name="user_id" required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password">كلمة المرور (اختياري)</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="type">النوع</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="live">بث مرئي</option>
                                <option value="audio_room">غرفة صوتية</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="status">الحالة</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="scheduled">مجدول</option>
                                <option value="live" selected>مباشر</option>
                                <option value="ended">منتهي</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="scheduled_at">وقت الجدولة (اختياري)</label>
                            <input type="datetime-local" class="form-control" id="scheduled_at" name="scheduled_at">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="thumbnail">الصورة المصغرة</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="thumbnail" name="thumbnail">
                            <label class="custom-file-label" for="thumbnail">اختر ملف...</label>
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

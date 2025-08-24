<div class="modal fade" id="editLiveStreamingModal{{ $stream->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editLiveStreamingModalLabel{{ $stream->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLiveStreamingModalLabel{{ $stream->id }}">تعديل البث:
                    {{ $stream->title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('live-streamings.update', $stream->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title{{ $stream->id }}">العنوان</label>
                        <input type="text" class="form-control" id="title{{ $stream->id }}" name="title"
                            value="{{ $stream->title }}" required>
                    </div>
                    <div class="form-group">
                        <label for="description{{ $stream->id }}">الوصف</label>
                        <textarea class="form-control" id="description{{ $stream->id }}" name="description" rows="3">{{ $stream->description }}</textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="user_id{{ $stream->id }}">المستخدم</label>
                            <select class="form-control" id="user_id{{ $stream->id }}" name="user_id" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $stream->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password{{ $stream->id }}">كلمة المرور (اتركه فارغاً لعدم التغيير)</label>
                            <input type="password" class="form-control" id="password{{ $stream->id }}"
                                name="password">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="type{{ $stream->id }}">النوع</label>
                            <select class="form-control" id="type{{ $stream->id }}" name="type" required>
                                <option value="live" {{ $stream->type == 'live' ? 'selected' : '' }}>بث مرئي</option>
                                <option value="audio_room" {{ $stream->type == 'audio_room' ? 'selected' : '' }}>غرفة
                                    صوتية</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="status{{ $stream->id }}">الحالة</label>
                            <select class="form-control" id="status{{ $stream->id }}" name="status" required>
                                <option value="scheduled" {{ $stream->status == 'scheduled' ? 'selected' : '' }}>مجدول
                                </option>
                                <option value="live" {{ $stream->status == 'live' ? 'selected' : '' }}>مباشر</option>
                                <option value="ended" {{ $stream->status == 'ended' ? 'selected' : '' }}>منتهي
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="scheduled_at{{ $stream->id }}">وقت الجدولة</label>
                            <input type="datetime-local" class="form-control" id="scheduled_at{{ $stream->id }}"
                                name="scheduled_at"
                                value="{{ $stream->scheduled_at ? $stream->scheduled_at->format('Y-m-d\TH:i') : '' }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>الصورة المصغرة الحالية:</label>
                        <img src="{{ $stream->thumbnail ? asset('storage/' . $stream->thumbnail) : asset('img/default-thumbnail.png') }}"
                            alt="Thumbnail" width="100">
                    </div>
                    <div class="form-group">
                        <label for="thumbnail{{ $stream->id }}">تغيير الصورة المصغرة</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="thumbnail{{ $stream->id }}"
                                name="thumbnail">
                            <label class="custom-file-label" for="thumbnail{{ $stream->id }}">اختر ملف...</label>
                        </div>
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

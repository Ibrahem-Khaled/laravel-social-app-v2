<div class="modal fade" id="editMessageModal{{ $m->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('contacts.update', $m) }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title">تعديل الرسالة</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group"><label>الموضوع</label><input type="text" name="subject"
                        value="{{ $m->subject }}" class="form-control" required></div>
                <div class="form-group"><label>الرسالة</label>
                    <textarea name="message" rows="5" class="form-control" required>{{ $m->message }}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>الحالة</label>
                        <select name="status" class="form-control">
                            @foreach (['open', 'pending', 'closed', 'spam'] as $s)
                                <option value="{{ $s }}" @selected($m->status->value === $s)>{{ $s }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>الأولوية</label>
                        <select name="priority" class="form-control">
                            @foreach (['low', 'normal', 'high', 'urgent'] as $p)
                                <option value="{{ $p }}" @selected($m->priority->value === $p)>{{ $p }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>التصنيف</label>
                        <select name="category" class="form-control">
                            @foreach (['general', 'support', 'sales', 'bug', 'feedback'] as $c)
                                <option value="{{ $c }}" @selected($m->category->value === $c)>{{ $c }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>المصدر</label>
                        <select name="source" class="form-control">
                            @foreach (['web', 'mobile', 'api'] as $src)
                                <option value="{{ $src }}" @selected($m->source->value === $src)>{{ $src }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>إضافة مرفقات جديدة</label>
                    <div class="custom-file">
                        <input type="file" name="attachments[]" class="custom-file-input" multiple>
                        <label class="custom-file-label">اختر ملفات...</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><button class="btn btn-secondary" data-dismiss="modal">إلغاء</button><button
                    class="btn btn-primary" type="submit">تحديث</button></div>
        </form>
    </div>
</div>

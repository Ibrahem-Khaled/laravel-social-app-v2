<form action="{{ route('messages.sendAnonymous') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="sendMessageModalLabel">إرسال رسالة جديدة</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="message" class="form-label">نص الرسالة</label>
            <textarea name="message" class="form-control" required></textarea>
        </div>
        {{-- <div class="mb-3">
            <label for="media" class="form-label">وسائط (اختياري)</label>
            <input type="file" name="media" class="form-control">
        </div> --}}
        <div class="mb-3">
            <label for="recipients" class="form-label">المستلمون</label>
            <button type="button" id="selectAllUsers" class="btn btn-sm btn-secondary mb-2">تحديد الكل</button>
            <select name="recipients[]" id="recipients" class="form-control" multiple>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->email }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="filters" class="form-label">التصفية (اختياري)</label>
            <select name="filters[]" class="form-control" multiple>
                <option value="male">ذكور</option>
                <option value="female">إناث</option>
                <option value="egypt">مستخدمون من مصر</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">إرسال</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
    </div>
</form>

<script>
    document.getElementById('selectAllUsers').addEventListener('click', function() {
        const selectBox = document.getElementById('recipients');
        for (let i = 0; i < selectBox.options.length; i++) {
            selectBox.options[i].selected = true;
        }
    });
</script>

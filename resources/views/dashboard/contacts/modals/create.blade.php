<div class="modal fade" id="createMessageModal" tabindex="-1" role="dialog" aria-labelledby="createMessageLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('contacts.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">إضافة رسالة جديدة</h5>
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="إغلاق"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                {{-- بيانات المُرسل (مستخدم أو زائر) --}}
                @auth
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    <div class="alert alert-info">سيتم ربط الرسالة بحسابك الحالي.</div>
                @endauth

                @guest
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>الاسم</label>
                            <input type="text" name="guest_name" class="form-control" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label>البريد</label>
                            <input type="email" name="guest_email" class="form-control" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label>الهاتف</label>
                            <input type="text" name="guest_phone" class="form-control">
                        </div>
                    </div>
                @endguest

                <div class="form-group">
                    <label>الموضوع</label>
                    <input type="text" name="subject" class="form-control" required maxlength="200">
                </div>

                <div class="form-group">
                    <label>الرسالة</label>
                    <textarea name="message" class="form-control" rows="5" required></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>الحالة</label>
                        <select name="status" class="form-control">
                            <option value="open" selected>open</option>
                            <option value="pending">pending</option>
                            <option value="closed">closed</option>
                            <option value="spam">spam</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>الأولوية</label>
                        <select name="priority" class="form-control">
                            <option value="normal" selected>normal</option>
                            <option value="low">low</option>
                            <option value="high">high</option>
                            <option value="urgent">urgent</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>التصنيف</label>
                        <select name="category" class="form-control">
                            <option value="general" selected>general</option>
                            <option value="support">support</option>
                            <option value="sales">sales</option>
                            <option value="bug">bug</option>
                            <option value="feedback">feedback</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>المصدر</label>
                        <select name="source" class="form-control">
                            <option value="web" selected>web</option>
                            <option value="mobile">mobile</option>
                            <option value="api">api</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>مرفقات (اختياري) — يمكنك اختيار ملفات متعددة</label>
                    <div class="custom-file">
                        <input type="file" name="attachments[]" class="custom-file-input" multiple>
                        <label class="custom-file-label">اختر ملفات...</label>
                    </div>
                    <small class="text-muted d-block mt-1">الأنواع المسموحة: jpg, png, webp, pdf, doc, docx, zip (حتى
                        5MB لكل ملف)</small>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                <button class="btn btn-primary" type="submit">حفظ</button>
            </div>
        </form>
    </div>
</div>

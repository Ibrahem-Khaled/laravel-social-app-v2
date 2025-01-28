<div class="modal fade" id="addUserFamilyModal" tabindex="-1" role="dialog" aria-labelledby="addUserFamilyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserFamilyModalLabel">إضافة مستخدم إلى العائلة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('user-families.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="famliy_id" value="{{ $family->id }}">
                    <div class="form-group">
                        <label for="user_id">اختر المستخدم</label>
                        <select name="user_id" id="user_id" class="form-control" required>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="role">الدور</label>
                        <input type="text" name="role" id="role" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="status">الحالة</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="pending">قيد الانتظار</option>
                            <option value="active">نشط</option>
                            <option value="inactive">غير نشط</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-primary">إضافة</button>
                </div>
            </form>
        </div>
    </div>
</div>
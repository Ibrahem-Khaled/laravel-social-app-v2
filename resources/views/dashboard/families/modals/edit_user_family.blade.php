<div class="modal fade" id="editUserFamilyModal{{ $user->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editUserFamilyModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserFamilyModalLabel{{ $user->id }}">تعديل مستخدم في العائلة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('user-families.update', $user->pivot->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="role">الدور</label>
                        <input type="text" name="role" id="role" class="form-control"
                            value="{{ $user->pivot->role }}">
                    </div>
                    <div class="form-group">
                        <label for="status">الحالة</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="pending" {{ $user->pivot->status == 'pending' ? 'selected' : '' }}>قيد
                                الانتظار</option>
                            <option value="active" {{ $user->pivot->status == 'active' ? 'selected' : '' }}>نشط</option>
                            <option value="inactive" {{ $user->pivot->status == 'inactive' ? 'selected' : '' }}>غير نشط
                            </option>
                        </select>
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

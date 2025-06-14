<div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">تعديل المستخدم: {{ $user->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">الاسم الكامل</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $user->name }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">اسم المستخدم</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    value="{{ $user->username }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">البريد الإلكتروني</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ $user->email }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">رقم الهاتف</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    value="{{ $user->phone }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">كلمة المرور (اتركه فارغاً إذا كنت لا تريد تغييره)</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_confirmation">تأكيد كلمة المرور</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role">الدور</label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>مستخدم عادي
                                    </option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>مدير</option>
                                    <option value="moderator" {{ $user->role === 'moderator' ? 'selected' : '' }}>مشرف
                                    </option>
                                    <option value="vip" {{ $user->role === 'vip' ? 'selected' : '' }}>مستخدم مميز
                                    </option>
                                    <option value="website-data"
                                        {{ $user->role === 'website-data' ? 'selected' : '' }}>بيانات الموقع</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">الحالة</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>نشط
                                    </option>
                                    <option value="inactive" {{ $user->status === 'inactive' ? 'selected' : '' }}>غير
                                        نشط</option>
                                    <option value="banned" {{ $user->status === 'banned' ? 'selected' : '' }}>محظور
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="gender">الجنس</label>
                                <select class="form-control" id="gender" name="gender">
                                    <option value="">اختر الجنس</option>
                                    <option value="male" {{ $user->gender === 'male' ? 'selected' : '' }}>ذكر
                                    </option>
                                    <option value="female" {{ $user->gender === 'female' ? 'selected' : '' }}>أنثى
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="birth_date">تاريخ الميلاد</label>
                                <input type="date" class="form-control" id="birth_date" name="birth_date"
                                    value="{{ $user->birth_date }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="avatar">الصورة الشخصية</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="avatar" name="avatar">
                            <label class="custom-file-label" for="avatar">اختر صورة</label>
                        </div>
                        @if ($user->avatar)
                            <small class="form-text text-muted">
                                الصورة الحالية: <a href="{{ asset('storage/' . $user->avatar) }}"
                                    target="_blank">عرض</a>
                            </small>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="bio">السيرة الذاتية</label>
                        <textarea class="form-control" id="bio" name="bio" rows="3">{{ $user->bio }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="coins">النقاط</label>
                        <input type="number" class="form-control" id="coins" name="coins"
                            value="{{ $user->coins }}">
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

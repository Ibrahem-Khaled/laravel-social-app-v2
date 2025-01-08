<form action="{{ $user ? route('users.update', $user->id) : route('users.store') }}" method="POST">
    @csrf
    @if ($user)
        @method('PUT')
    @endif
    <div class="modal-header">
        <h5 class="modal-title">{{ $user ? 'تعديل بيانات المستخدم' : 'إضافة مستخدم جديد' }}</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="username" class="form-label">اسم المستخدم</label>
            <input type="text" name="username" class="form-control" value="{{ $user->username ?? '' }}" required>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">الاسم</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name ?? '' }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">البريد الإلكتروني</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email ?? '' }}" required>
        </div>
        @if (!$user)
            <div class="mb-3">
                <label for="password" class="form-label">كلمة المرور</label>
                <input type="password" name="password" class="form-control" required>
            </div>
        @endif
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">{{ $user ? 'حفظ التعديلات' : 'إضافة' }}</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
    </div>
</form>

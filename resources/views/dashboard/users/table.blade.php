<thead>
    <tr>
        <th>المعرف</th>
        <th>الحالة</th>
        <th>الاسم</th>
        <th>اسم المستخدم</th>
        <th>البريد الإلكتروني</th>
        <th>الدولة</th>
        <th>النقاط </th>
        <th>الإجراءات</th>
    </tr>
</thead>
<tbody>
    @foreach ($users as $user)
        <tr>
            <td>{{ $user->uuid }}</td>
            <td>{{ $user->status }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->country ?? 'غير محددة' }}</td>
            <td>{{ $user->coins ?? 'غير محددة' }}</td>
            <td>
                <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm">عرض الملف الشخصي</a>
                <button class="btn btn-success" data-toggle="modal"
                    data-target="#editUserModal{{ $user->id }}">تعديل</button>
                <button class="btn btn-primary" data-toggle="modal"
                    data-target="#manageCoinsModal{{ $user->id }}">إدارة النقاط</button>
                <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                </form>
                <form action="{{ route('users.toggleBan', $user->id) }}" method="POST" style="display: inline-block;">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-warning" onclick="return confirm('هل أنت متأكد؟')">
                        {{ $user->status == 'banned' ? 'إلغاء الحظر' : 'حظر' }}
                    </button>
                </form>
            </td>
        </tr>

        <!-- Manage Coins Modal -->
        <div class="modal fade" id="manageCoinsModal{{ $user->id }}" tabindex="-1"
            aria-labelledby="manageCoinsLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('users.manageCoins', $user->id) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">إدارة النقاط - {{ $user->name }}</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="coins" class="form-label">عدد النقاط</label>
                                <input type="number" name="coins" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="action" class="form-label">الإجراء</label>
                                <select name="action" class="form-control" required>
                                    <option value="add">إضافة نقاط</option>
                                    <option value="subtract">سحب نقاط</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">تنفيذ</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Edit User Modal -->
        <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1"
            aria-labelledby="editUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    @include('dashboard.users.form', ['user' => $user])
                </div>
            </div>
        </div>
    @endforeach
</tbody>

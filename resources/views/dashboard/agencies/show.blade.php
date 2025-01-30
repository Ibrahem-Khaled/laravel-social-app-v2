@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>مستخدمي الوكالة</h1>

        <!-- تفاصيل الوكالة الحالية -->
        <div class="card mb-4">
            <div class="card-header">
                <h2>تفاصيل الوكالة</h2>
            </div>
            <div class="card-body">
                <p><strong>اسم الوكالة:</strong> {{ $agency->name }}</p>
                <p><strong>وصف الوكالة:</strong> {{ $agency->description }}</p>
                <p><strong>حالة الوكالة:</strong> {{ $agency->status }}</p>
            </div>
        </div>

        <!-- زر إنشاء مستخدم جديد -->
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#agencyUserModal">
            إنشاء مستخدم جديد
        </button>

        <!-- جدول عرض المستخدمين -->
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الوكالة</th>
                    <th>المستخدم</th>
                    <th>الدور</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($agency->users as $agencyUser)
                    <tr>
                        <td>{{ $agencyUser->id }}</td>
                        <td>{{ $agencyUser->agency->name }}</td>
                        <td>{{ $agencyUser->user->name }}</td>
                        <td>{{ $agencyUser->role }}</td>
                        <td>{{ $agencyUser->status }}</td>
                        <td>
                            <!-- زر التعديل -->
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                data-target="#agencyUserModal" data-id="{{ $agencyUser->id }}"
                                data-agency-id="{{ $agencyUser->agency_id }}" data-user-id="{{ $agencyUser->user_id }}"
                                data-role="{{ $agencyUser->role }}" data-status="{{ $agencyUser->status }}">
                                تعديل
                            </button>
                            <!-- زر الحذف -->
                            <form action="{{ route('agency-users.destroy', $agencyUser) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal لإضافة/تعديل مستخدم -->
    <div class="modal fade" id="agencyUserModal" tabindex="-1" aria-labelledby="agencyUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agencyUserModalLabel">إنشاء/تعديل مستخدم الوكالة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="agencyUserForm" method="POST">
                        @csrf
                        <input type="hidden" id="agencyUserId" name="id">
                        <div class="form-group">
                            <label for="agency_id">الوكالة</label>
                            <select name="agency_id" id="agency_id" class="form-control" required>
                                @foreach ($agencies as $agency)
                                    <option value="{{ $agency->id }}">{{ $agency->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="user_id">المستخدم</label>
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                            <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#agencyUserModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');

                if (id) {
                    // تعديل مستخدم موجود
                    var agencyId = button.data('agency-id');
                    var userId = button.data('user-id');
                    var role = button.data('role');
                    var status = button.data('status');

                    $('#agencyUserId').val(id);
                    $('#agency_id').val(agencyId);
                    $('#user_id').val(userId);
                    $('#role').val(role);
                    $('#status').val(status);

                    $('#agencyUserModalLabel').text('تعديل مستخدم الوكالة');
                    $('#agencyUserForm').attr('action', '{{ url('agency-users') }}/' + id);
                    $('#agencyUserForm').append('<input type="hidden" name="_method" value="PUT">');
                } else {
                    // إنشاء مستخدم جديد
                    $('#agencyUserModalLabel').text('إنشاء مستخدم جديد');
                    $('#agencyUserForm').attr('action', '{{ route('agency-users.store') }}');
                    $('#agencyUserForm').find('input[name="_method"]').remove();
                }
            });

            $('#agencyUserModal').on('hidden.bs.modal', function() {
                $('#agencyUserForm')[0].reset();
                $('#agencyUserId').val('');
                $('#agencyUserForm').find('input[name="_method"]').remove();
            });
        });
    </script>
@endsection
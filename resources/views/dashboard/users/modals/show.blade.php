<div class="modal fade" id="showUserModal{{ $user->id }}" tabindex="-1" role="dialog"
    aria-labelledby="showUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showUserModalLabel">تفاصيل المستخدم</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('img/default-avatar.png') }}"
                            alt="{{ $user->name }}" class="img-fluid rounded-circle mb-3" width="150">
                        <h4>{{ $user->name }}</h4>
                        <span
                            class="badge
                            {{ $user->role === 'admin'
                                ? 'badge-danger'
                                : ($user->role === 'moderator'
                                    ? 'badge-warning'
                                    : ($user->role === 'vip'
                                        ? 'badge-success'
                                        : 'badge-secondary')) }}">
                            {{ $user->role_name }}
                        </span>
                    </div>
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>اسم المستخدم</th>
                                    <td>{{ $user->username }}</td>
                                </tr>
                                <tr>
                                    <th>البريد الإلكتروني</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>رقم الهاتف</th>
                                    <td>{{ $user->phone ?? 'غير متوفر' }}</td>
                                </tr>
                                <tr>
                                    <th>الحالة</th>
                                    <td>
                                        <span
                                            class="badge
                                            {{ $user->status === 'active'
                                                ? 'badge-success'
                                                : ($user->status === 'inactive'
                                                    ? 'badge-secondary'
                                                    : 'badge-danger') }}">
                                            {{ $user->status_name }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>الجنس</th>
                                    <td>{{ $user->gender_name }}</td>
                                </tr>
                                <tr>
                                    <th>تاريخ الميلاد</th>
                                    <td>{{ $user->birth_date ? $user->birth_date->format('Y-m-d') : 'غير محدد' }}</td>
                                </tr>
                                <tr>
                                    <th>البلد</th>
                                    <td>{{ $user->country ?? 'غير محدد' }}</td>
                                </tr>
                                <tr>
                                    <th>النقاط</th>
                                    <td>{{ $user->coins }}</td>
                                </tr>
                                <tr>
                                    <th>تاريخ التسجيل</th>
                                    <td>{{ $user?->created_at?->format('Y-m-d H:i') }}</td>
                                </tr>
                            </table>
                        </div>

                        @if ($user->bio)
                            <div class="card mt-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">السيرة الذاتية</h6>
                                </div>
                                <div class="card-body">
                                    <p>{{ $user->bio }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>

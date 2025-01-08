@extends('layouts.app')

@section('content')
    <div class="container mt-4 text-right">
        <h1>إدارة الإشعارات</h1>
        @include('components.alerts')

        <!-- التقارير -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <i class="fas fa-bell fa-3x text-primary mb-3"></i>
                        <h3>{{ $totalNotifications }}</h3>
                        <p>إجمالي الإشعارات</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <i class="fas fa-eye fa-3x text-success mb-3"></i>
                        <h3>{{ $readNotifications }}</h3>
                        <p>الإشعارات المقروءة</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <i class="fas fa-eye-slash fa-3x text-danger mb-3"></i>
                        <h3>{{ $unreadNotifications }}</h3>
                        <p>الإشعارات غير المقروءة</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <i class="fas fa-users fa-3x text-info mb-3"></i>
                        <h3>{{ $uniqueUsers }}</h3>
                        <p>المستخدمون المستلمون</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- زر فتح المودال لإضافة إشعار -->
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addNotificationModal">إضافة إشعار
            جديد</button>

        <!-- المودال -->
        <div class="modal fade" id="addNotificationModal" tabindex="-1" aria-labelledby="addNotificationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('notifications.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addNotificationModalLabel">إضافة إشعار جديد</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="user_id" class="form-label">المستخدم</label>
                                <select name="user_id" class="form-control" required>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="type" class="form-label">نوع الإشعار</label>
                                <input type="text" name="type" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">نص الإشعار</label>
                                <textarea name="message" class="form-control" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">إضافة</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- جدول الإشعارات -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th>المستخدم</th>
                    <th>النوع</th>
                    <th>الإشعار</th>
                    <th>الحالة</th>
                    <th>تاريخ الإرسال</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($notifications as $notification)
                    <tr>
                        <td>
                            <input type="checkbox" name="notification_ids[]" value="{{ $notification->id }}">
                        </td>
                        <td>{{ $notification->user->name }}</td>
                        <td>{{ $notification->type }}</td>
                        <td>{{ $notification->message }}</td>
                        <td>
                            @if ($notification->is_read)
                                <span class="badge bg-success">مقروء</span>
                            @else
                                <span class="badge bg-danger">غير مقروء</span>
                            @endif
                        </td>
                        <td>{{ $notification->created_at->diffForHumans() }}</td>
                        <td>
                            @if (!$notification->is_read)
                                <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-primary">تعليم كمقروء</button>
                                </form>
                            @endif
                            <form action="{{ route('notifications.delete', $notification->id) }}" method="POST"
                                style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                            </form>

                            <button class="btn btn-sm btn-warning" data-toggle="modal"
                                data-target="#editNotificationModal{{ $notification->id }}">تعديل</button>
                            <div class="modal fade" id="editNotificationModal{{ $notification->id }}" tabindex="-1"
                                aria-labelledby="editNotificationModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('notifications.update', $notification->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editNotificationModalLabel">تعديل الإشعار
                                                </h5>
                                                <button type="button" class="btn-close" data-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="user_id" class="form-label">المستخدم</label>
                                                    <select name="user_id" class="form-control" required>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}"
                                                                {{ $notification->user_id == $user->id ? 'selected' : '' }}>
                                                                {{ $user->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="type" class="form-label">نوع الإشعار</label>
                                                    <input type="text" name="type" class="form-control"
                                                        value="{{ $notification->type }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="message" class="form-label">نص الإشعار</label>
                                                    <textarea name="message" class="form-control" rows="3" required>{{ $notification->message }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">إلغاء</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">لا توجد إشعارات</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $notifications->links() }}
        </div>
    </div>
@endsection

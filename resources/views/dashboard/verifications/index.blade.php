@extends('layouts.app')

@section('content')
    <div class="container mt-4 text-right">
        <h1>طلبات التوثيق</h1>
        @include('components.alerts')

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>المستخدم</th>
                    <th>الاسم الرباعي</th>
                    <th>الوجه الأمامي</th>
                    <th>الوجه الخلفي</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($verificationRequests as $request)
                    <tr>
                        <td><a href="{{ route('users.show', $request->user->id) }}">{{ $request->user->name }}</a> </td>
                        <td>{{ $request->full_name }}</td>
                        <td><a href="{{ asset('storage/' . $request->front_id_image) }}" target="_blank">عرض</a></td>
                        <td><a href="{{ asset('storage/' . $request->back_id_image) }}" target="_blank">عرض</a></td>
                        <td>{{ $request->status }}</td>
                        <td>
                            @if ($request->status == 'pending')
                                <form action="{{ route('verification.approve', $request->id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">قبول</button>
                                </form>
                                <button class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#rejectModal{{ $request->id }}">رفض</button>
                                <!-- رفض -->
                                <div class="modal fade" id="rejectModal{{ $request->id }}" tabindex="-1"
                                    aria-labelledby="rejectModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('verification.reject', $request->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">سبب الرفض</h5>
                                                    <button type="button" class="btn-close" data-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <textarea name="rejection_reason" class="form-control" rows="3" required></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-danger">رفض</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">إلغاء</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">لا توجد طلبات توثيق</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">
            {{ $verificationRequests->links() }}
        </div>
    </div>
@endsection

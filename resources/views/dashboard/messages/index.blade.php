@extends('layouts.app')

@section('content')
    <div class="container mt-4 text-right">
        <h1>الرسائل</h1>
        @include('components.alerts')

        <!-- إحصائيات -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <i class="fas fa-envelope fa-3x text-primary mb-3"></i>
                        <h3>{{ $totalMessages }}</h3>
                        <p>إجمالي الرسائل</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <i class="fas fa-envelope-open-text fa-3x text-success mb-3"></i>
                        <h3>{{ $readMessages }}</h3>
                        <p>الرسائل المقروءة</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <i class="fas fa-envelope fa-3x text-danger mb-3"></i>
                        <h3>{{ $unreadMessages }}</h3>
                        <p>الرسائل غير المقروءة</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <i class="fas fa-users fa-3x text-info mb-3"></i>
                        <h3>{{ $anonymousMessages }}</h3>
                        <p>الرسائل المجهولة</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- زر فتح المودال -->
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#sendMessageModal">إرسال رسالة جديدة</button>

        <!-- Modal لإرسال الرسائل -->
        <div class="modal fade" id="sendMessageModal" tabindex="-1" aria-labelledby="sendMessageModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    @include('dashboard.messages.form', ['message' => null])
                </div>
            </div>
        </div>

        <!-- جدول الرسائل -->
        <form action="{{ route('messages.deleteMultiple') }}" method="POST">
            @csrf
            @method('DELETE')
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll"></th>
                        <th>المرسل</th>
                        <th>المستلم</th>
                        <th>الرسالة</th>
                        <th>الحالة</th>
                        <th>تاريخ الإرسال</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($messages as $message)
                        <tr>
                            <td>
                                <input type="checkbox" name="message_ids[]" value="{{ $message->id }}">
                            </td>
                            <td>{{ $message->is_anonymous ? 'مجهول' : $message->sender->name }}</td>
                            <td>{{ $message->receiver->name }}</td>
                            <td>{{ $message->message }}</td>
                            <td>
                                @if ($message->is_read)
                                    <i class="fas fa-envelope-open text-success" title="مقروءة"></i> مقروءة
                                @else
                                    <i class="fas fa-envelope text-danger" title="غير مقروءة"></i> غير مقروءة
                                @endif
                            </td>
                            <td>{{ $message->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">لا توجد رسائل</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($messages->count() > 0)
                <button type="submit" class="btn btn-danger mt-3"
                    onclick="return confirm('هل أنت متأكد من حذف الرسائل المحددة؟')">
                    حذف الرسائل المحددة
                </button>
            @endif
        </form>

        <div class="mt-3">
            {{ $messages->links() }}
        </div>
    </div>

    <script>
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[name="message_ids[]"]');
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });
    </script>
@endsection

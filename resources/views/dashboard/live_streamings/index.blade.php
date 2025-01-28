@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">البثوث المباشرة</h1>

        <!-- زر فتح المودال -->
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#liveStreamingModal">
            إضافة بث مباشر
        </button>

        <!-- مودال إضافة / تعديل البث -->
        <div class="modal fade" id="liveStreamingModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">
                            {{ isset($liveStreaming) ? 'تعديل البث' : 'إضافة بث مباشر' }}</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <div class="modal-body">
                        <form id="liveStreamingForm"
                            action="{{ isset($liveStreaming) ? route('live_streamings.update', $liveStreaming->id) : route('live_streamings.store') }}"
                            method="POST">
                            @csrf
                            @if (isset($liveStreaming))
                                @method('PUT')
                            @endif

                            <div class="mb-3">
                                <label for="user_id" class="form-label">معرف المستخدم</label>
                                <select name="user_id" class="form-control" required>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ isset($liveStreaming) && $liveStreaming->user_id == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="agency_id" class="form-label">معرف الوكالة</label>
                                <select name="agency_id" class="form-control">
                                    @foreach ($agencies as $agency)
                                        <option value="{{ $agency->id }}"
                                            {{ isset($liveStreaming) && $liveStreaming->agency_id == $agency->id ? 'selected' : '' }}>
                                            {{ $agency->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="title" class="form-label">العنوان</label>
                                <input type="text" name="title" class="form-control"
                                    value="{{ isset($liveStreaming) ? $liveStreaming->title : '' }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">الوصف</label>
                                <textarea name="description" class="form-control">{{ isset($liveStreaming) ? $liveStreaming->description : '' }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">الحالة</label>
                                <select name="status" class="form-control" required>
                                    <option value="pending"
                                        {{ isset($liveStreaming) && $liveStreaming->status == 'pending' ? 'selected' : '' }}>
                                        معلق</option>
                                    <option value="live"
                                        {{ isset($liveStreaming) && $liveStreaming->status == 'live' ? 'selected' : '' }}>
                                        مباشر</option>
                                    <option value="completed"
                                        {{ isset($liveStreaming) && $liveStreaming->status == 'completed' ? 'selected' : '' }}>
                                        مكتمل</option>
                                    <option value="cancelled"
                                        {{ isset($liveStreaming) && $liveStreaming->status == 'cancelled' ? 'selected' : '' }}>
                                        ملغي</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="scheduled_at" class="form-label">الجدولة</label>
                                <input type="datetime-local" name="scheduled_at" class="form-control"
                                    value="{{ isset($liveStreaming) && $liveStreaming->scheduled_at ? $liveStreaming->scheduled_at->format('Y-m-d\TH:i') : '' }}">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                                <button type="submit"
                                    class="btn btn-primary">{{ isset($liveStreaming) ? 'تحديث' : 'إضافة' }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- قائمة البثوث المباشرة -->
        <h2 class="mt-5">قائمة البثوث</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>المعرف</th>
                    <th>العنوان</th>
                    <th>الحالة</th>
                    <th>معرف البث</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($liveStreamings as $liveStreaming)
                    <tr>
                        <td>{{ $liveStreaming->id }}</td>
                        <td>{{ $liveStreaming->title }}</td>
                        <td>{{ $liveStreaming->status }}</td>
                        <td>{{ $liveStreaming->live_streaming_id }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#liveStreamingModal"
                                onclick="editLiveStreaming({{ json_encode($liveStreaming) }})">تعديل</button>
                            <form action="{{ route('live_streamings.destroy', $liveStreaming->id) }}" method="POST"
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

    <script>
        function editLiveStreaming(liveStreaming) {
            document.querySelector('[name=user_id]').value = liveStreaming.user_id;
            document.querySelector('[name=agency_id]').value = liveStreaming.agency_id;
            document.querySelector('[name=title]').value = liveStreaming.title;
            document.querySelector('[name=description]').value = liveStreaming.description;
            document.querySelector('[name=status]').value = liveStreaming.status;
            document.querySelector('[name=scheduled_at]').value = liveStreaming.scheduled_at ? liveStreaming.scheduled_at
                .replace(' ', 'T') : '';
        }
    </script>
@endsection

<!-- resources/views/agencies/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>الوكالات</h1>
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#agencyModal">
            إضافة وكالة
        </button>
        <table class="table">
            <thead>
                <tr>
                    <th>صاحب الوكالة</th>
                    <th>الاسم</th>
                    <th>الوصف</th>
                    <th>الصورة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($agencies as $agency)
                    <tr>
                        <td>{{ $agency->user->name }} -- {{ $agency->user->email }}</td>
                        <td>{{ $agency->name }}</td>
                        <td>{{ $agency->description }}</td>
                        <td>
                            @if ($agency->image)
                                <img src="{{ asset('storage/' . $agency->image) }}" alt="{{ $agency->name }}"
                                    style="max-width: 100px;">
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#agencyModal"
                                data-id="{{ $agency->id }}" data-name="{{ $agency->name }}"
                                data-description="{{ $agency->description }}" data-user-id="{{ $agency->user_id }}">
                                تعديل
                            </button>
                            <form action="{{ route('agencies.destroy', $agency->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">حذف</button>
                            </form>
                            <a href="{{ route('agencies.show', $agency->id) }}" class="btn btn-info">عرض المستخدمين الخاصين بالوكالة</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="agencyModal" tabindex="-1" role="dialog" aria-labelledby="agencyModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agencyModalLabel">إضافة/تعديل وكالة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="agencyForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="agencyId" name="id">
                        <div class="form-group">
                            <label for="user_id">المستخدم</label>
                            <select class="form-control" id="user_id" name="user_id" required>
                                <option value="">اختر مستخدمًا</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} -- {{ $user->email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">الاسم</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">الوصف</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">الصورة</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#agencyModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');
            var description = button.data('description');
            var userId = button.data('user-id');
            var modal = $(this);

            if (id) {
                modal.find('.modal-title').text('تعديل وكالة');
                modal.find('#agencyId').val(id);
                modal.find('#name').val(name);
                modal.find('#description').val(description);
                modal.find('#user_id').val(userId);
                modal.find('form').attr('action', '{{ route('agencies.update', '') }}/' + id);
                modal.find('form').append('<input type="hidden" name="_method" value="PUT">');
            } else {
                modal.find('.modal-title').text('إضافة وكالة');
                modal.find('#agencyId').val('');
                modal.find('#name').val('');
                modal.find('#description').val('');
                modal.find('#user_id').val('');
                modal.find('form').attr('action', '{{ route('agencies.store') }}');
                modal.find('input[name="_method"]').remove();
            }
        });
    </script>
@endpush

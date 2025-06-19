@php
    $levels = \App\Models\Level::all();
@endphp
@foreach ($users as $user)
    <!-- Modal for changing user level -->
    <div class="modal fade" id="changeLevelModal{{ $user->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تغيير مستوى المستخدم</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('users.setLevel', $user->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="level_id">المستوى الحالي:
                                {{ $user?->current_level?->name ?? 'بدون مستوى' }}</label>
                            <select class="form-control" id="level_id" name="level_id" required>
                                <option value="">اختر مستوى جديد</option>
                                @foreach ($levels as $level)
                                    <option value="{{ $level->id }}"
                                        {{ $user->level_id == $level->id ? 'selected' : '' }}>
                                        {{ $level->name }} ({{ $level->points_required }} نقطة)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

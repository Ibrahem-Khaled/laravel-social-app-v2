<div class="modal fade" id="showGameModal{{ $game->id }}" tabindex="-1" role="dialog"
    aria-labelledby="showGameModalLabel{{ $game->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showGameModalLabel{{ $game->id }}">تفاصيل اللعبة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <img src="{{ asset('storage/' . $game->image) }}" alt="{{ $game->name }}"
                        class="img-fluid rounded" style="max-height: 200px;">
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th>الاسم</th>
                        <td>{{ $game->name }}</td>
                    </tr>
                    <tr>
                        <th>الرابط</th>
                        <td><a href="{{ $game->url }}" target="_blank">اضغط هنا لزيارة اللعبة</a></td>
                    </tr>
                    <tr>
                        <th>الترتيب</th>
                        <td>{{ $game->position }}</td>
                    </tr>
                    <tr>
                        <th>الحالة</th>
                        <td>
                            <span class="badge badge-{{ $game->is_active ? 'success' : 'danger' }}">
                                {{ $game->is_active ? 'مفعل' : 'غير مفعل' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>تاريخ الإضافة</th>
                        <td>{{ $game->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>

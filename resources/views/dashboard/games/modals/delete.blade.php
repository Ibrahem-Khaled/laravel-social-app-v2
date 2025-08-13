<div class="modal fade" id="deleteGameModal{{ $game->id }}" tabindex="-1" role="dialog"
    aria-labelledby="deleteGameModalLabel{{ $game->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteGameModalLabel{{ $game->id }}">تأكيد الحذف</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                هل أنت متأكد من أنك تريد حذف اللعبة: <strong>{{ $game->name }}</strong>؟
                <br>
                <small class="text-danger">لا يمكن التراجع عن هذا الإجراء!</small>
            </div>
            <div class="modal-footer">
                <form action="{{ route('games.destroy', $game->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger">تأكيد الحذف</button>
                </form>
            </div>
        </div>
    </div>
</div>

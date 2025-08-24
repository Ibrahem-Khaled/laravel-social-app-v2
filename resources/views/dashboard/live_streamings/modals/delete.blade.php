<div class="modal fade" id="deleteLiveStreamingModal{{ $stream->id }}" tabindex="-1" role="dialog"
    aria-labelledby="deleteLiveStreamingModalLabel{{ $stream->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteLiveStreamingModalLabel{{ $stream->id }}">تأكيد الحذف</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                هل أنت متأكد من أنك تريد حذف البث المباشر: <strong>{{ $stream->title }}</strong>؟ لا يمكن التراجع عن هذا
                الإجراء.
            </div>
            <div class="modal-footer">
                <form action="{{ route('live-streamings.destroy', $stream->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger">نعم، حذف</button>
                </form>
            </div>
        </div>
    </div>
</div>

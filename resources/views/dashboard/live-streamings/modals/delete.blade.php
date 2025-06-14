<div class="modal-header">
    <h5 class="modal-title" id="deleteStreamModalLabel{{ $stream->id }}">حذف البث</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="alert alert-warning">
        <h5><i class="fas fa-exclamation-triangle"></i> تحذير!</h5>
        <p class="mb-0">هل أنت متأكد من رغبتك في حذف هذا البث؟ لا يمكن التراجع عن هذا الإجراء.</p>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $stream->title }}</h5>
            <p class="card-text text-muted">{{ Str::limit($stream->description, 100) }}</p>
            <div class="d-flex justify-content-between">
                <span class="badge badge-{{ $stream->type == 'live' ? 'primary' : 'info' }}">
                    {{ $stream->type == 'live' ? 'بث فيديو' : 'غرفة صوتية' }}
                </span>
                <span class="badge badge-{{ $stream->status ? 'success' : 'danger' }}">
                    {{ $stream->status ? 'نشط' : 'غير نشط' }}
                </span>
                <span class="badge badge-success">
                    <i class="fas fa-heart"></i> {{ $stream->likes }}
                </span>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
    <form action="{{ route('live-streamings.destroy', $stream->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">
            <i class="fas fa-trash"></i> حذف نهائي
        </button>
    </form>
</div>

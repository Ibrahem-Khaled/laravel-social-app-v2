<div class="modal fade" id="deleteLevelModal{{ $level->id }}" tabindex="-1" role="dialog"
    aria-labelledby="deleteLevelModalLabel{{ $level->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteLevelModalLabel{{ $level->id }}">تأكيد الحذف</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <h5><i class="fas fa-exclamation-triangle"></i> تحذير!</h5>
                    <p>أنت على وشك حذف المستوى التالي:</p>
                    <ul>
                        <li>رقم المستوى: <strong>{{ $level->level_number }}</strong></li>
                        @if ($level->name)
                            <li>اسم المستوى: <strong>{{ $level->name }}</strong></li>
                        @endif
                        <li>النقاط المطلوبة: <strong>{{ number_format($level->points_required) }}</strong></li>
                    </ul>

                    @if ($level->users_count > 0)
                        <div class="alert alert-danger mt-3">
                            <i class="fas fa-users"></i> يوجد <strong>{{ $level->users_count }}</strong> مستخدمين
                            مرتبطين بهذا المستوى.
                            <br>سيتم نقلهم إلى المستوى الافتراضي عند الحذف.
                        </div>
                    @endif
                </div>

                <p>هل أنت متأكد من أنك تريد حذف هذا المستوى؟</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                <form action="{{ route('levels.destroy', $level->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">نعم، احذف المستوى</button>
                </form>
            </div>
        </div>
    </div>
</div>

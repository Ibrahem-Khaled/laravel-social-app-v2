<div class="modal fade" id="deleteSectionModal{{ $section->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteSectionModalLabel{{ $section->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteSectionModalLabel{{ $section->id }}">تأكيد الحذف</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                هل أنت متأكد من رغبتك في حذف السكشن "<strong>{{ $section->highlighted_title }}</strong>"؟
                <br>
                <small class="text-danger">لا يمكن التراجع عن هذا الإجراء.</small>
            </div>
            <div class="modal-footer">
                <form action="{{ route('feature-sections.destroy', $section->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger">نعم، احذف</button>
                </form>
            </div>
        </div>
    </div>
</div>

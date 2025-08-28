<div class="modal fade" id="deleteMessageModal{{ $m->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('contacts.destroy', $m) }}" method="POST" class="modal-content">
            @csrf @method('DELETE')
            <div class="modal-header">
                <h5 class="modal-title">حذف الرسالة</h5><button type="button" class="close"
                    data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">هل أنت متأكد من حذف هذه الرسالة وجميع مرفقاتها؟</div>
            <div class="modal-footer"><button class="btn btn-secondary" data-dismiss="modal">إلغاء</button><button
                    class="btn btn-danger" type="submit">حذف</button></div>
        </form>
    </div>
</div>

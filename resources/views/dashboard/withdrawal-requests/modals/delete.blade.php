<!-- Delete Withdrawal Request Modal -->
<div class="modal fade" id="deleteRequestModal{{ $request->id }}" tabindex="-1" role="dialog"
    aria-labelledby="deleteRequestModalLabel{{ $request->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('withdrawal-requests.destroy', $request->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteRequestModalLabel{{ $request->id }}">تأكيد الحذف</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    هل أنت متأكد من رغبتك في حذف طلب السحب رقم <strong>#{{ $request->id }}</strong>؟
                    <p class="text-danger mt-2">لا يمكن التراجع عن هذا الإجراء.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger">نعم، قم بالحذف</button>
                </div>
            </form>
        </div>
    </div>
</div>

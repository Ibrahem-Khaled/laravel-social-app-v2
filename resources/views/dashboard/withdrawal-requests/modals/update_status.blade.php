<!-- Update Status Modal -->
<div class="modal fade" id="updateStatusModal{{ $request->id }}" tabindex="-1" role="dialog"
    aria-labelledby="updateStatusModalLabel{{ $request->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('withdrawal-requests.update', $request->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="updateStatusModalLabel{{ $request->id }}">تحديث حالة الطلب
                        #{{ $request->id }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="status{{ $request->id }}">الحالة الجديدة</label>
                        <select name="status" id="status{{ $request->id }}" class="form-control"
                            onchange="toggleRejectionReason(this, '{{ $request->id }}')">
                            <option value="approved">موافق عليه (Approved)</option>
                            <option value="completed">مكتمل (Completed)</option>
                            <option value="rejected">مرفوض (Rejected)</option>
                        </select>
                    </div>
                    <div class="form-group" id="rejection-reason-group-{{ $request->id }}" style="display: none;">
                        <label for="rejection_reason{{ $request->id }}">سبب الرفض</label>
                        <textarea name="rejection_reason" id="rejection_reason{{ $request->id }}" class="form-control" rows="3"></textarea>
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

@push('scripts')
    <script>
        // This script needs to be pushed only once, so we check if it's already defined.
        if (typeof window.toggleRejectionReason === 'undefined') {
            window.toggleRejectionReason = function(selectElement, requestId) {
                const rejectionReasonGroup = document.getElementById('rejection-reason-group-' + requestId);
                if (selectElement.value === 'rejected') {
                    rejectionReasonGroup.style.display = 'block';
                } else {
                    rejectionReasonGroup.style.display = 'none';
                }
            }
        }
    </script>
@endpush

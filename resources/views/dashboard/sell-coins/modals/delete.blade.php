<div class="modal fade" id="deleteCoinModal{{ $coin->id }}" tabindex="-1" role="dialog"
    aria-labelledby="deleteCoinModalLabel{{ $coin->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCoinModalLabel{{ $coin->id }}">حذف عرض بيع العملات</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('sell-coins.destroy', $coin->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>هل أنت متأكد من رغبتك في حذف هذا العرض؟</p>
                    <p><strong>الكمية:</strong> {{ number_format($coin->amount) }}</p>
                    <p><strong>السعر:</strong> {{ number_format($coin->price, 2) }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger">حذف</button>
                </div>
            </form>
        </div>
    </div>
</div>

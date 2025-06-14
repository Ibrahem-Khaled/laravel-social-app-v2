<div class="modal fade" id="showCoinModal{{ $coin->id }}" tabindex="-1" role="dialog"
    aria-labelledby="showCoinModalLabel{{ $coin->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showCoinModalLabel{{ $coin->id }}">تفاصيل عرض بيع العملات</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">الكمية:</div>
                    <div class="col-md-8">{{ number_format($coin->amount) }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">السعر:</div>
                    <div class="col-md-8">{{ number_format($coin->price, 2) }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">الأيقونة:</div>
                    <div class="col-md-8">
                        @if ($coin->icon)
                            <img src="{{ asset('storage/' . $coin->icon) }}" alt="Coin Icon" width="60">
                        @else
                            <i class="fas fa-coins fa-2x text-gray-300"></i>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">الحالة:</div>
                    <div class="col-md-8">
                        <span class="badge badge-{{ $coin->is_active ? 'success' : 'danger' }}">
                            {{ $coin->is_active ? 'نشط' : 'غير نشط' }}
                        </span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">المنصة:</div>
                    <div class="col-md-8">
                        <span class="badge badge-{{ $coin->platform === 'mobile' ? 'info' : 'primary' }}">
                            {{ $coin->platform === 'mobile' ? 'موبايل' : 'ويب' }}
                        </span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">تاريخ الإنشاء:</div>
                    <div class="col-md-8">{{ $coin->created_at->format('Y-m-d H:i') }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4 font-weight-bold">آخر تحديث:</div>
                    <div class="col-md-8">{{ $coin->updated_at->format('Y-m-d H:i') }}</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>

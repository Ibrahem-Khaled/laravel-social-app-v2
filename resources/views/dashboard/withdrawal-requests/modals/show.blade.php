<!-- Show Withdrawal Request Modal -->
<div class="modal fade" id="showRequestModal{{ $request->id }}" tabindex="-1" role="dialog"
    aria-labelledby="showRequestModalLabel{{ $request->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showRequestModalLabel{{ $request->id }}">تفاصيل طلب السحب
                    #{{ $request->id }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>معلومات المستخدم</h5>
                        <p><strong>الاسم:</strong> {{ $request->user->name }}</p>
                        <p><strong>البريد الإلكتروني:</strong> {{ $request->user->email }}</p>
                        <p><strong>رقم الهاتف:</strong> {{ $request->user->phone ?? 'غير متوفر' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>معلومات الطلب</h5>
                        <p><strong>المبلغ:</strong> {{ number_format($request->amount, 2) }} {{ $request->currency }}
                        </p>
                        <p><strong>تاريخ الطلب:</strong> {{ $request->created_at->format('Y-m-d H:i A') }}</p>
                        <p><strong>الحالة:</strong> {{ $statusNames[$request->status] ?? $request->status }}</p>
                        @if ($request->status === 'rejected' && $request->rejection_reason)
                            <p><strong>سبب الرفض:</strong> {{ $request->rejection_reason }}</p>
                        @endif
                        @if ($request->processed_at)
                            <p><strong>تاريخ المعالجة:</strong> {{ $request->processed_at->format('Y-m-d H:i A') }}</p>
                        @endif
                    </div>
                </div>
                <hr>
                <h5>تفاصيل المحفظة</h5>
                <p><strong>اسم المحفظة:</strong> {{ $request->wallet->wallet_name }}</p>
                <p><strong>نوع المحفظة:</strong> {{ $request->wallet->wallet_type }}</p>
                <h6>البيانات:</h6>
                <div class="bg-light p-3 rounded">
                    <pre class="mb-0"><code>{{ json_encode($request->wallet->wallet_details, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editCoinModal{{ $coin->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editCoinModalLabel{{ $coin->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCoinModalLabel{{ $coin->id }}">تعديل عرض بيع العملات</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('sell-coins.update', $coin->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="amount">الكمية</label>
                        <input type="number" class="form-control" id="amount" name="amount"
                            value="{{ $coin->amount }}" required min="1">
                    </div>

                    <div class="form-group">
                        <label for="price">السعر</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price"
                            value="{{ $coin->price }}" required min="0">
                    </div>

                    <div class="form-group">
                        <label for="icon">الأيقونة (اختياري)</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="icon" name="icon">
                            <label class="custom-file-label" for="icon">
                                {{ $coin->icon ? 'تغيير الأيقونة' : 'اختر ملف' }}
                            </label>
                        </div>
                        @if ($coin->icon)
                            <small class="form-text text-muted">
                                الأيقونة الحالية:
                                <img src="{{ asset('storage/' . $coin->icon) }}" alt="Current Icon" width="30"
                                    class="ml-2">
                            </small>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="platform">المنصة</label>
                        <select class="form-control" id="platform" name="platform" required>
                            <option value="mobile" {{ $coin->platform === 'mobile' ? 'selected' : '' }}>موبايل</option>
                            <option value="web" {{ $coin->platform === 'web' ? 'selected' : '' }}>ويب</option>
                        </select>
                    </div>

                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active"
                            {{ $coin->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">نشط</label>
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

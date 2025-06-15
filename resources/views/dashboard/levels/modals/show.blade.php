<div class="modal fade" id="showLevelModal{{ $level->id }}" tabindex="-1" role="dialog"
    aria-labelledby="showLevelModalLabel{{ $level->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showLevelModalLabel{{ $level->id }}">تفاصيل المستوى</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    @if ($level->icon)
                        <i class="{{ $level->icon }}"
                            style="font-size: 3em; color: {{ $level->color ?? '#6c757d' }};"></i>
                    @endif
                    <h3 class="mt-2">
                        <span class="badge level-badge"
                            style="background-color: {{ $level->color ?? '#6c757d' }}; color: white;">
                            المستوى {{ $level->level_number }}
                            @if ($level->name)
                                - {{ $level->name }}
                            @endif
                        </span>
                    </h3>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fas fa-bullseye"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">النقاط المطلوبة</span>
                                <span class="info-box-number">{{ number_format($level->points_required) }} نقطة</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box">
                            <span class="info-box-icon {{ $level->is_active ? 'bg-success' : 'bg-danger' }}">
                                <i class="fas {{ $level->is_active ? 'fa-check' : 'fa-ban' }}"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">الحالة</span>
                                <span class="info-box-number">{{ $level->is_active ? 'نشط' : 'معطل' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($level->description)
                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="card-title">وصف المستوى</h6>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ $level->description }}</p>
                        </div>
                    </div>
                @endif

                <div class="mt-3">
                    <h6>إحصائيات:</h6>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            عدد المستخدمين في هذا المستوى
                            <span class="badge badge-primary badge-pill">{{ $level->users_count ?? 0 }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            تم إنشاؤه في
                            <span>{{ $level->created_at->format('Y-m-d') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            آخر تحديث
                            <span>{{ $level->updated_at->format('Y-m-d') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>

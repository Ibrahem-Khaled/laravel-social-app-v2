<div class="modal fade" id="showMessageModal{{ $m->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">عرض الرسالة</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <dl class="row">
                    <dt class="col-sm-3">المرسل</dt>
                    <dd class="col-sm-9">
                        @if ($m->user)
                            {{ $m->user->name }} (ID: {{ $m->user->id }})
                        @else
                            {{ $m->guest_name }} — {{ $m->guest_email }}
                        @endif
                    </dd>
                    <dt class="col-sm-3">الموضوع</dt>
                    <dd class="col-sm-9">{{ $m->subject }}</dd>
                    <dt class="col-sm-3">الرسالة</dt>
                    <dd class="col-sm-9">
                        <pre class="mb-0">{{ $m->message }}</pre>
                    </dd>
                    <dt class="col-sm-3">الحالة/الأولوية</dt>
                    <dd class="col-sm-9">{{ $m->status->value }} / {{ $m->priority->value }}</dd>
                    <dt class="col-sm-3">المصدر</dt>
                    <dd class="col-sm-9">{{ $m->source->value }}</dd>
                    <dt class="col-sm-3">IP/UA</dt>
                    <dd class="col-sm-9">{{ $m->ip_address }} / <span class="text-muted">{{ $m->user_agent }}</span>
                    </dd>
                </dl>

                <hr>
                <h6>المرفقات</h6>
                @forelse($m->attachments as $att)
                    <div class="d-flex align-items-center justify-content-between border rounded p-2 mb-2">
                        <div>
                            <i class="fas fa-paperclip"></i> {{ $att->original_name ?? basename($att->path) }}
                            <small class="text-muted">({{ $att->mime }},
                                {{ number_format(($att->size ?? 0) / 1024, 0) }} KB)</small>
                        </div>
                        <div class="text-nowrap">
                            <a class="btn btn-sm btn-outline-secondary"
                                href="{{ route('attachments.download', $att) }}"><i class="fas fa-download"></i>
                                تنزيل</a>
                            <button class="btn btn-sm btn-outline-danger" data-toggle="modal"
                                data-target="#deleteAttachmentModal{{ $att->id }}"><i
                                    class="fas fa-trash"></i></button>
                        </div>
                    </div>

                    {{-- مودال حذف المرفق --}}
                    <div class="modal fade" id="deleteAttachmentModal{{ $att->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('attachments.destroy', $att) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <div class="modal-header">
                                        <h5 class="modal-title">حذف المرفق</h5><button type="button" class="close"
                                            data-dismiss="modal"><span>&times;</span></button>
                                    </div>
                                    <div class="modal-body">تأكيد حذف هذا المرفق؟</div>
                                    <div class="modal-footer"><button class="btn btn-secondary"
                                            data-dismiss="modal">إلغاء</button><button class="btn btn-danger"
                                            type="submit">حذف</button></div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">لا توجد مرفقات</p>
                @endforelse
            </div>
            <div class="modal-footer"><button class="btn btn-secondary" data-dismiss="modal">إغلاق</button></div>
        </div>
    </div>
</div>

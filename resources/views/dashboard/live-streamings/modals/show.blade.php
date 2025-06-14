<div class="modal-header">
    <h5 class="modal-title" id="showStreamModalLabel{{ $stream->id }}">تفاصيل البث</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="row mb-4">
        <div class="col-md-4 text-center">
            @if ($stream->thumbnail)
                <img src="{{ asset('storage/' . $stream->thumbnail) }}" alt="{{ $stream->title }}"
                    class="img-fluid rounded">
            @else
                <div class="bg-secondary text-white d-flex align-items-center justify-content-center"
                    style="height: 150px;">
                    <i class="fas fa-video fa-3x"></i>
                </div>
            @endif
        </div>
        <div class="col-md-8">
            <h4>{{ $stream->title }}</h4>
            <p class="text-muted">{{ $stream->description }}</p>

            <div class="row mt-3">
                <div class="col-6">
                    <p><strong>النوع:</strong>
                        @if ($stream->type == 'live')
                            <span class="badge badge-primary">بث فيديو</span>
                        @else
                            <span class="badge badge-info">غرفة صوتية</span>
                        @endif
                    </p>
                    <p><strong>الحالة:</strong>
                        <span class="badge badge-{{ $stream->status ? 'success' : 'danger' }}">
                            {{ $stream->status ? 'نشط' : 'غير نشط' }}
                        </span>
                    </p>
                </div>
                <div class="col-6">
                    <p><strong>التفاعل:</strong>
                        <span class="badge badge-success">
                            <i class="fas fa-heart"></i> {{ $stream->likes }}
                        </span>
                    </p>
                    @if ($stream->password)
                        <p><strong>كلمة المرور:</strong> {{ $stream->password }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h6 class="m-0 font-weight-bold">معلومات المنشئ</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <img src="{{ $stream->user->avatar ? asset('storage/' . $stream->user->avatar) : asset('img/default-avatar.png') }}"
                            alt="{{ $stream->user->name }}" class="rounded-circle mr-3" width="50" height="50">
                        <div>
                            <h6 class="mb-0">{{ $stream->user->name }}</h6>
                            <small class="text-muted">{{ $stream->user->email }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-light">
                    <h6 class="m-0 font-weight-bold">معلومات الوكالة</h6>
                </div>
                <div class="card-body">
                    @if ($stream->agency)
                        <div class="d-flex align-items-center">
                            @if ($stream->agency->logo)
                                <img src="{{ asset('storage/' . $stream->agency->logo) }}"
                                    alt="{{ $stream->agency->name }}" class="rounded-circle mr-3" width="50"
                                    height="50">
                            @endif
                            <div>
                                <h6 class="mb-0">{{ $stream->agency->name }}</h6>
                                <small class="text-muted">{{ $stream->agency->email }}</small>
                            </div>
                        </div>
                    @else
                        <p class="text-muted mb-0">لا توجد وكالة</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if ($stream->scheduled_at)
        <div class="alert alert-info mt-3">
            <div class="d-flex align-items-center">
                <i class="fas fa-clock fa-2x mr-3"></i>
                <div>
                    <h5 class="mb-1">بث مجدول</h5>
                    <p class="mb-0">
                        سيبدأ البث في
                        <strong>{{ $stream->scheduled_at->format('Y-m-d H:i') }}</strong>
                        ({{ $stream->scheduled_at->diffForHumans() }})
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
    <a href="{{ route('live-streamings.edit', $stream->id) }}" class="btn btn-primary">
        <i class="fas fa-edit"></i> تعديل
    </a>
</div>

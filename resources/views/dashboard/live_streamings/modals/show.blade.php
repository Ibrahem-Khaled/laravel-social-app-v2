<div class="modal fade" id="showLiveStreamingModal{{ $stream->id }}" tabindex="-1" role="dialog"
    aria-labelledby="showLiveStreamingModalLabel{{ $stream->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showLiveStreamingModalLabel{{ $stream->id }}">تفاصيل البث:
                    {{ $stream->title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img src="{{ $stream->thumbnail ? asset('storage/' . $stream->thumbnail) : asset('img/default-thumbnail.png') }}"
                            class="img-fluid rounded mb-3" alt="{{ $stream->title }}">
                    </div>
                    <div class="col-md-8">
                        <table class="table table-bordered">
                            <tr>
                                <th>المعرف</th>
                                <td>{{ $stream->id }}</td>
                            </tr>
                            <tr>
                                <th>العنوان</th>
                                <td>{{ $stream->title }}</td>
                            </tr>
                            <tr>
                                <th>المستخدم</th>
                                <td>{{ $stream->user->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>الوصف</th>
                                <td>{{ $stream->description ?? 'لا يوجد وصف' }}</td>
                            </tr>
                            <tr>
                                <th>النوع</th>
                                <td>{{ $stream->type == 'live' ? 'بث مرئي' : 'غرفة صوتية' }}</td>
                            </tr>
                            <tr>
                                <th>الحالة</th>
                                <td>{{ $statusNames[$stream->status] ?? $stream->status }}</td>
                            </tr>
                            <tr>
                                <th>الإعجابات</th>
                                <td>{{ $stream->likes }}</td>
                            </tr>
                            <tr>
                                <th>وقت الجدولة</th>
                                <td>{{ $stream->scheduled_at ? $stream->scheduled_at->format('Y-m-d H:i A') : 'غير مجدول' }}
                                </td>
                            </tr>
                            <tr>
                                <th>تاريخ الإنشاء</th>
                                <td>{{ $stream->created_at->format('Y-m-d H:i A') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>

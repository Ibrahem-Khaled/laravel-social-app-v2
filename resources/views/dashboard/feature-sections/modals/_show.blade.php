<!-- Show Section Modal -->
<div class="modal fade" id="showSectionModal{{ $section->id }}" tabindex="-1" role="dialog" aria-labelledby="showSectionModalLabel{{ $section->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showSectionModalLabel{{ $section->id }}">تفاصيل السكشن: {{ $section->highlighted_title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img src="{{ asset('storage/' . $section->image_path) }}" class="img-fluid rounded shadow-sm mb-3" alt="{{ $section->image_alt }}">
                        <h6 class="font-weight-bold">المعرف (Slug)</h6>
                        <p><span class="badge badge-dark">{{ $section->slug }}</span></p>
                    </div>
                    <div class="col-md-8">
                        <h5 class="font-weight-bold border-bottom pb-2 mb-3">
                            {{ $section->title_before_highlight }}
                            <span class="text-primary">{{ $section->highlighted_title }}</span>
                            {{ $section->title_after_highlight }}
                        </h5>
                        <p class="text-gray-700">{{ $section->description }}</p>
                        <hr>
                        <h6 class="font-weight-bold">المميزات:</h6>
                        <ul class="list-group list-group-flush">
                            @foreach($section->items as $item)
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fas fa-check-circle text-success mr-2"></i>
                                {{ $item->text }}
                            </li>
                            @endforeach
                        </ul>
                        <hr>
                        <a href="{{ $section->button_url }}" class="btn btn-primary mt-2" target="_blank">
                           {{ $section->button_text }} <i class="fas fa-external-link-alt fa-sm ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>

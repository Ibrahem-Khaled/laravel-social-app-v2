@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @include('components.alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">إدارة الأسئلة الشائعة</h5>
                        <button class="btn btn-light" data-toggle="modal" data-target="#addFaqModal">
                            <i class="fas fa-plus"></i> إضافة سؤال جديد
                        </button>
                    </div>
                    <div class="card-body">
                        <!-- Filters and Stats -->
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <form method="GET" action="{{ route('faqs.index') }}" class="form-inline">
                                    <div class="form-group mr-3">
                                        <select class="form-control" name="category">
                                            <option value="all">جميع الفئات</option>
                                            @foreach ($categories as $key => $category)
                                                <option value="{{ $key }}"
                                                    {{ $selectedCategory == $key ? 'selected' : '' }}>
                                                    {{ $category }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mr-3">
                                        <input type="text" class="form-control" name="search" placeholder="بحث..."
                                            value="{{ request('search') }}">
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-filter"></i> تطبيق
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-4 text-right">
                                <div class="d-flex justify-content-end">
                                    <div class="mr-3 text-center">
                                        <div class="text-muted">الإجمالي</div>
                                        <h4 class="mb-0">{{ $totalFaqs }}</h4>
                                    </div>
                                    <div class="mr-3 text-center">
                                        <div class="text-muted">نشطة</div>
                                        <h4 class="mb-0 text-success">{{ $activeFaqs }}</h4>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-muted">مميزة</div>
                                        <h4 class="mb-0 text-warning">{{ $featuredFaqs }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- FAQs Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>السؤال</th>
                                        <th>الفئة</th>
                                        <th>المشاهدات</th>
                                        <th>الحالة</th>
                                        <th>مميز</th>
                                        <th>تاريخ الإنشاء</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($faqs as $index => $faq)
                                        <tr>
                                            <td>{{ $faqs->firstItem() + $index }}</td>
                                            <td>{{ Str::limit($faq->question, 50) }}</td>
                                            <td><span class="badge badge-info">{{ $categories[$faq->category] }}</span>
                                            </td>
                                            <td>{{ $faq->views }}</td>
                                            <td>
                                                <form action="{{ route('faqs.toggle-status', $faq->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="btn btn-sm {{ $faq->is_active ? 'btn-success' : 'btn-secondary' }}">
                                                        {{ $faq->is_active ? 'نشط' : 'غير نشط' }}
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <form action="{{ route('faqs.toggle-featured', $faq->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="btn btn-sm {{ $faq->is_featured ? 'btn-warning' : 'btn-light' }}">
                                                        <i
                                                            class="fas {{ $faq->is_featured ? 'fa-star' : 'fa-star text-muted' }}"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td>{{ $faq->created_at->format('Y-m-d') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                    data-target="#editFaqModal{{ $faq->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" data-toggle="modal"
                                                    data-target="#deleteFaqModal{{ $faq->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal for each FAQ -->
                                        <div class="modal fade" id="editFaqModal{{ $faq->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="editFaqModalLabel{{ $faq->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title" id="editFaqModalLabel{{ $faq->id }}">
                                                            تعديل السؤال</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form method="POST" action="{{ route('faqs.update', $faq->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label
                                                                    for="edit_question{{ $faq->id }}">السؤال</label>
                                                                <input type="text" class="form-control"
                                                                    id="edit_question{{ $faq->id }}" name="question"
                                                                    value="{{ $faq->question }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="edit_answer{{ $faq->id }}">الإجابة</label>
                                                                <textarea class="form-control" id="edit_answer{{ $faq->id }}" name="answer" rows="5" required>{{ $faq->answer }}</textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="edit_category{{ $faq->id }}">الفئة</label>
                                                                <select class="form-control"
                                                                    id="edit_category{{ $faq->id }}" name="category"
                                                                    required>
                                                                    @foreach ($categories as $key => $category)
                                                                        <option value="{{ $key }}"
                                                                            {{ $faq->category == $key ? 'selected' : '' }}>
                                                                            {{ $category }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="edit_is_featured{{ $faq->id }}"
                                                                    name="is_featured"
                                                                    {{ $faq->is_featured ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="edit_is_featured{{ $faq->id }}">مميز</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="edit_is_active{{ $faq->id }}"
                                                                    name="is_active"
                                                                    {{ $faq->is_active ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="edit_is_active{{ $faq->id }}">نشط</label>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">إلغاء</button>
                                                            <button type="submit" class="btn btn-primary">حفظ
                                                                التغييرات</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete Modal for each FAQ -->
                                        <div class="modal fade" id="deleteFaqModal{{ $faq->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="deleteFaqModalLabel{{ $faq->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title"
                                                            id="deleteFaqModalLabel{{ $faq->id }}">تأكيد الحذف</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>هل أنت متأكد أنك تريد حذف هذا السؤال؟ لا يمكن التراجع عن هذا
                                                            الإجراء.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">إلغاء</button>
                                                        <form method="POST"
                                                            action="{{ route('faqs.destroy', $faq->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">حذف</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $faqs->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Most Viewed FAQs -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">الأكثر مشاهدة</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            @foreach ($mostViewed as $faq)
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $faq->question }}</h6>
                                        <small>{{ $faq->views }} مشاهدة</small>
                                    </div>
                                    <small class="text-muted">{{ $categories[$faq->category] }}</small>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add FAQ Modal -->
    <div class="modal fade" id="addFaqModal" tabindex="-1" role="dialog" aria-labelledby="addFaqModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addFaqModalLabel">إضافة سؤال جديد</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('faqs.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="question">السؤال</label>
                            <input type="text" class="form-control" id="question" name="question" required>
                        </div>
                        <div class="form-group">
                            <label for="answer">الإجابة</label>
                            <textarea class="form-control" id="answer" name="answer" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="category">الفئة</label>
                            <select class="form-control" id="category" name="category" required>
                                @foreach ($categories as $key => $category)
                                    <option value="{{ $key }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured">
                            <label class="form-check-label" for="is_featured">مميز</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                            <label class="form-check-label" for="is_active">نشط</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

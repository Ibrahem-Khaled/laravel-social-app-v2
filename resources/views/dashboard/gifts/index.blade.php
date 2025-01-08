@extends('layouts.app')

@section('content')
    <div class="container mt-4 text-right">
        <h1>إدارة الهدايا</h1>

        <!-- قسم الإحصائيات -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white text-center">
                    <div class="card-body">
                        <h3>{{ $totalGifts }}</h3>
                        <p>إجمالي الهدايا</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white text-center">
                    <div class="card-body">
                        <h3>{{ $activeGifts }}</h3>
                        <p>الهدايا النشطة</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-dark text-center">
                    <div class="card-body">
                        <h3>{{ $inactiveGifts }}</h3>
                        <p>الهدايا غير النشطة</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white text-center">
                    <div class="card-body">
                        <h3>{{ number_format($averagePrice, 2) }}</h3>
                        <p>متوسط سعر الهدايا</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h5>أغلى هدية</h5>
                        <h4>{{ $highestPricedGift->title ?? 'غير متوفرة' }}</h4>
                        <p class="text-muted">{{ $highestPricedGift->price ?? 'غير متوفرة' }} نقطة</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h5>أرخص هدية</h5>
                        <h4>{{ $lowestPricedGift->title ?? 'غير متوفرة' }}</h4>
                        <p class="text-muted">{{ $lowestPricedGift->price ?? 'غير متوفرة' }} نقطة</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- البحث -->
        <form action="{{ route('gifts.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="ابحث عن هدية"
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">بحث</button>
            </div>
        </form>
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addGiftModal">إضافة هدية جديدة</button>

        @include('components.alerts')

        <!-- جدول الهدايا -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>المعرف</th>
                    <th>العنوان</th>
                    <th>الوصف</th>
                    <th>السعر</th>
                    <th>الصورة</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($gifts as $gift)
                    <tr>
                        <td>{{ $gift->id }}</td>
                        <td>{{ $gift->title }}</td>
                        <td>{{ Str::limit($gift->description, 50) }}</td>
                        <td>{{ $gift->price }} نقطة</td>
                        <td><img src="{{ asset('storage/' . $gift->image) }}" alt="Gift Image" width="50" height="50"></td>
                        <td>{{ $gift->is_active ? 'نشطة' : 'غير نشطة' }}</td>
                        <td>
                            <button class="btn btn-success" data-toggle="modal"
                                data-target="#editGiftModal{{ $gift->id }}">تعديل</button>
                            <form action="{{ route('gifts.destroy', $gift) }}" method="POST"
                                style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Gift Modal -->
                    <div class="modal fade" id="editGiftModal{{ $gift->id }}" tabindex="-1"
                        aria-labelledby="editGiftModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                @include('dashboard.gifts.form', ['gift' => $gift])
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">لا توجد هدايا</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $gifts->links() }}
        </div>
    </div>

    <!-- Add Gift Modal -->
    <div class="modal fade" id="addGiftModal" tabindex="-1" aria-labelledby="addGiftModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                @include('dashboard.gifts.form', ['gift' => null])
            </div>
        </div>
    </div>
@endsection

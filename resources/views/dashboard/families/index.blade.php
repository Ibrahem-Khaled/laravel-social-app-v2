@extends('layouts.app')

@section('content')
    <h1>العائلات</h1>
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addFamilyModal">إنشاء عائلة</button>
    @include('components.alerts')
    <table class="table">
        <thead>
            <tr>
                <th>بيانات صاحب العائلة</th>
                <th>الاسم</th>
                <th>الوصف</th>
                <th>الصورة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($families as $family)
                <tr>
                    <td>{{ $family->user->name }} -- {{ $family->user->email }} -- {{ $family->user->phone }}</td>
                    <td>{{ $family->name }}</td>
                    <td>{{ $family->description }}</td>
                    <td>
                        @if ($family->image)
                            <img src="{{ asset('storage/' . $family->image) }}" alt="{{ $family->name }}" width="100">
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('families.show', $family->id) }}" class="btn btn-info">عرض</a>
                        <button class="btn btn-warning" data-toggle="modal"
                            data-target="#editFamilyModal{{ $family->id }}">تعديل</button>
                        <form action="{{ route('families.destroy', $family->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">حذف</button>
                        </form>
                    </td>
                </tr>
                <!-- Modal لتعديل العائلة -->
                @include('dashboard.families.modals.edit_family', ['family' => $family])
            @endforeach
        </tbody>
    </table>

    <!-- Modal لإضافة عائلة -->
    @include('dashboard.families.modals.add_family')
@endsection

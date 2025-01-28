@extends('layouts.app')

@section('content')
    <h1>تفاصيل العائلة: {{ $family->name }}</h1>
    <p>الوصف: {{ $family->description }}</p>
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addUserFamilyModal">
        إضافة مستخدم
    </button>
    @include('components.alerts')
    <h2>الأعضاء</h2>
    <table class="table">
        <thead>
            <tr>
                <th>الاسم</th>
                <th>الدور</th>
                <th>الحالة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($family->users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->pivot->role }}</td>
                    <td>{{ $user->pivot->status }}</td>
                    <td>
                        <button class="btn btn-warning" data-toggle="modal"
                            data-target="#editUserFamilyModal{{ $user->id }}">تعديل</button>
                        <form action="{{ route('user-families.destroy', $user->pivot->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">حذف</button>
                        </form>
                    </td>
                </tr>
                <!-- Modal لتعديل المستخدم -->
                @include('dashboard.families.modals.edit_user_family', [
                    'user' => $user,
                    'family' => $family,
                    'users' => $users,
                ])
            @endforeach
        </tbody>
    </table>
    <!-- Modal لإضافة مستخدم -->
    @include('dashboard.families.modals.add_user_family', ['family' => $family, 'users' => $users])
@endsection

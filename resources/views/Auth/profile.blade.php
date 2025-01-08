<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الملف الشخصي</title>
    @include('components.seo')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        h1 {
            color: #4a2f85;
        }

        .profile-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            border-radius: 8px;
        }

        .btn-primary {
            background-color: #4a2f85;
            border: none;
        }

        .btn-primary:hover {
            background-color: #3a2370;
        }
    </style>
</head>

<body>
    @include('components.header')

    <div class="container mt-5">
        <h1 class="text-center mb-4">الملف الشخصي</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="profile-card">
                    <form method="POST" action="{{ route('user.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- الاسم -->
                        <div class="mb-3">
                            <label for="name" class="form-label">الاسم</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ auth()->user()->name }}" required>
                        </div>

                        <!-- البريد الإلكتروني -->
                        <div class="mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني</label>
                            <input type="email" name="email" id="email" class="form-control"
                                value="{{ auth()->user()->email }}">
                        </div>

                        <!-- رقم الهاتف -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">رقم الهاتف</label>
                            <input type="text" name="phone" id="phone" class="form-control"
                                value="{{ auth()->user()->phone }}">
                        </div>

                        <!-- العنوان -->
                        <div class="mb-3">
                            <label for="address" class="form-label">العنوان</label>
                            <input type="text" name="address" id="address" class="form-control"
                                value="{{ auth()->user()->address }}">
                        </div>

                        <!-- الصورة الشخصية -->
                        <div class="mb-3">
                            <label for="avatar" class="form-label">الصورة الشخصية</label>
                            <input type="file" name="avatar" id="avatar" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">تحديث البيانات</button>
                    </form>

                    <hr class="my-4">

                    <!-- زر تغيير كلمة المرور -->
                    <button class="btn btn-danger w-100" data-bs-toggle="modal"
                        data-bs-target="#changePasswordModal">تغيير كلمة المرور</button>
                </div>
            </div>
        </div>
    </div>

    <!-- مودال تغيير كلمة المرور -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">تغيير كلمة المرور</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('user.update.password') }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <!-- كلمة المرور الحالية -->
                        <div class="mb-3">
                            <label for="current_password" class="form-label">كلمة المرور الحالية</label>
                            <input type="password" name="current_password" id="current_password" class="form-control"
                                required>
                        </div>
                        <!-- كلمة المرور الجديدة -->
                        <div class="mb-3">
                            <label for="new_password" class="form-label">كلمة المرور الجديدة</label>
                            <input type="password" name="new_password" id="new_password" class="form-control" required>
                        </div>
                        <!-- تأكيد كلمة المرور الجديدة -->
                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">تأكيد كلمة المرور الجديدة</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">تحديث</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

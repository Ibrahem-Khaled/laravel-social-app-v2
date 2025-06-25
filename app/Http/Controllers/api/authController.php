<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;

class authController extends Controller
{
    public function login(Request $request)
    {
        // استخراج بيانات الاعتماد من الطلب
        $credentials = $request->only('email', 'password');

        // التحقق من صحة البيانات المدخلة
        $validator = Validator::make($credentials, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'بيانات الاعتماد غير صحيحة'], 401);
        }

        // محاولة تسجيل الدخول والتحقق من صحة كلمة المرور
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'بيانات الاعتماد غير صحيحة'], 401);
        }

        // إرجاع التوكن وبيانات المستخدم
        return response()->json([
            'token' => $token,
            'user' => auth()->guard('api')->user(),
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|unique:users',
            'gender' => 'nullable|string|in:male,female',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $username = Str::slug($request->name) . '-' . Str::random(5);
        $user = User::where('username', $username)->first();
        while ($user) {
            $username = Str::slug($request->name) . '-' . Str::random(5);
            $user = User::where('username', $username)->first();
        }
        // إنشاء المستخدم الجديد
        $user = User::create([
            'username' => $username,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'password' => bcrypt($request->password),
        ]);
        $token = JWTAuth::fromUser($user);
        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }


    public function checkPhoneExistence(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // تأكد من أن رقم الهاتف بنفس الصيغة التي تخزنها في قاعدة البيانات
            // يفضل استخدام صيغة دولية مثل +201001234567
            'phone_number' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $phoneNumber = $request->input('phone_number');

        $userExists = User::where('phone', 'LIKE', '%' . $phoneNumber . '%')->exists();

        return response()->json([
            'exists' => $userExists,
        ]);
    }

    public function verifyPhoneNumber(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $idToken = $request->input('id_token');
        $auth = app('firebase.auth');

        try {
            $verifiedIdToken = $auth->verifyIdToken($idToken);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid ID Token.'], 401);
        }

        $firebaseUser = $auth->getUser($verifiedIdToken->claims()->get('sub'));
        $phoneNumber = $firebaseUser->phoneNumber;

        // --- الجزء الجديد والمهم ---
        // 1. ابحث عن المستخدم في قاعدة بياناتك
        $user = User::where('phone', 'LIKE', '%' . $phoneNumber . '%')->first();

        // 2. إذا لم تجد المستخدم لسبب ما، أرجع خطأ
        if (!$user) {
            return response()->json(['message' => 'User not found in our database.'], 404);
        }

        // 3. أنشئ token خاص بلارافيل ليسجل المستخدم دخوله
        $apiToken = JWTAuth::fromUser($user);

        // 4. أرجع بيانات المستخدم مع الـ token
        return response()->json([
            'message' => 'Login successful!',
            'user' => $user, // يمكنك إرجاع بيانات المستخدم التي يحتاجها التطبيق
            'api_token' => $apiToken,
        ]);
    }

    public function user(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            return response()->json(['user' => $user]);
        } catch (JWTException $e) {
            return response()->json(['error' => 'غير مصرح به'], 401);
        }
    }

    public function update(Request $request)
    {
        // الحصول على المستخدم الحالي من التوكن
        $user = JWTAuth::parseToken()->authenticate();

        // التحقق من صحة البيانات المدخلة
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|unique:users,phone,' . $user->id,
            'gender' => 'required|string|in:male,female',
            'avatar' => 'nullable|image|max:2048',
            'bio' => 'nullable|string|max:500',
            'address' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // التحقق من وجود ملف صورة في الطلب
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');

            // توليد اسم فريد للصورة
            $filename = time() . '_' . uniqid() . '.' . $avatar->getClientOriginalExtension();

            // تخزين الصورة في مجلد "avatars" داخل القرص "public"
            $path = $avatar->storeAs('avatars', $filename, 'public');

            // توليد رابط الصورة العام باستخدام asset() أو Storage::url()
            $avatarUrl = asset('storage/' . $path);

            // تحديث رابط الصورة الخاصة بالمستخدم
            $user->avatar = $avatarUrl;
        }

        // تحديث باقي بيانات المستخدم
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->gender = $request->input('gender');
        $user->bio = $request->input('bio');
        $user->address = $request->input('address');
        $user->country = $request->input('country');
        $user->birth_date = $request->input('birth_date');
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'تم تحديث الملف الشخصي بنجاح',
            'user' => $user,
        ], 200);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6',
            'confirm_password' => 'required|string|same:new_password',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = JWTAuth::parseToken()->authenticate();

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return response()->json(['error' => 'كلمة المرور الحالية غير صحيحة'], 422);
        }

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'تم تغيير كلمة المرور بنجاح',
        ], 200);
    }

    public function getUser(User $user, Request $request)
    {
        $currentUser = auth()->guard('api')->user();

        if ($currentUser->blockedUsers()
            ->where('blocked_user_id', $user->id)
            ->exists()
        ) {
            return response()->json(['error' => 'هذا المستخدم محظور'], 403);
        }

        // عدد المنشورات في الصفحة الواحدة (يمكن تغييره عبر ?per_page=...)
        $perPage = $request->input('per_page', 10);

        // جلب المنشورات مع Pagination
        $posts = $user->posts()
            ->with(['user', 'likes', 'comments', 'message'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->appends($request->only(['page', 'per_page']));

        return response()->json([
            'user'  => $user,
            'posts' => $posts
        ]);
    }

    public function addExpoPushToken(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $user->expo_push_token = $request->input('expo_push_token');
        $user->save();
        return response()->json('success added token');
    }

    public function deleteAccount()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $user->delete();
        return response()->json('success deleted account');
    }
}

<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

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
            'user' => auth()->user(),
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
        ]);
        $token = JWTAuth::fromUser($user);
        return response()->json([
            'user' => $user,
            'token' => $token,
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

    public function getUser(User $user)
    {
        $currentUser = auth()->guard('api')->user();

        // التحقق مما إذا كان المستخدم الحالي قد حظر المستخدم المطلوب
        if ($currentUser->blockedUsers()->where('blocked_user_id', $user->id)->exists()) {
            return response()->json(['error' => 'هذا المستخدم محظور'], 403);
        }

        $posts = $user->posts()->with('user', 'message')->get();
        return response()->json([
            'user' => $user,
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

}

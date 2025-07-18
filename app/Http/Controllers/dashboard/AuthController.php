<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class AuthController extends Controller
{
    public function profile()
    {
        $user = auth()->user();
        // return response()->json($user);
        $followersCount = $user->followers()->count();
        $followingCount = $user->followings()->count();
        $giftsCount = $user->gifts()->count();
        return view('Auth.profile', compact('user', 'followersCount', 'followingCount', 'giftsCount'));
    }

    public function profileUpdate()
    {
        $user = auth()->user();
        return view('Auth.profile-edit', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|unique:users,phone,' . auth()->id(),
            'address' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->save();

        return redirect()->back()->with('success', 'تم تحديث البيانات بنجاح.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'كلمة المرور الحالية غير صحيحة.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'تم تغيير كلمة المرور بنجاح.');
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('home.dashboard')->with('success', 'تم تسجيل الدخول بنجاح.');
        }
        return view('Auth.login');
    }

    public function customLogin(Request $request)
    {
        // التحقق من صحة الإدخال (يبقى كما هو)
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'يجب إدخال بريد إلكتروني صالح.',
            'password.required' => 'كلمة المرور مطلوبة.',
            'password.min' => 'يجب أن تحتوي كلمة المرور على 6 أحرف على الأقل.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (auth()->attempt($credentials, $remember)) {
            // إعادة إنشاء الجلسة كإجراء أمني جيد
            $request->session()->regenerate();

            // تحديد المسار الافتراضي بناءً على دور المستخدم
            $defaultRoute = auth()->user()->role === 'admin' ? route('home.dashboard') : route('home');

            // إعادة التوجيه إلى الصفحة المقصودة، أو إلى المسار الافتراضي
            return redirect()->intended($defaultRoute)->with('success', 'تم تسجيل الدخول بنجاح.');
        }

        return redirect()->back()->with('error', 'تفاصيل تسجيل الدخول غير صحيحة. يرجى المحاولة مرة أخرى.');
    }


    public function register()
    {
        if (Auth::check()) {
            return redirect()->route('home.dashboard')->with('success', 'تم تسجيل الدخول بنجاح.');
        }
        return view('Auth.register');
    }

    public function customRegister(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'username' => 'required|min:3|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        // Hash the password
        $data['password'] = bcrypt($data['password']);

        // Create the user
        $user = User::create($data);

        // Log the new user in
        Auth::login($user);

        // Redirect to the intended page, or to the 'home' route as a fallback
        return redirect()->intended(route('home'))->with('success', 'تم إنشاء حسابك وتسجيل دخولك بنجاح');
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logout successful.');
    }
    public function deleteAccount()
    {
        $user = Auth::user();
        try {
            // تسجيل الخروج للمستخدم من الجلسة الحالية
            Auth::logout();

            // حذف حساب المستخدم من قاعدة البيانات
            $user->delete();

            // إبطال الجلسة الحالية ومسح بياناتها
            $request->session()->invalidate();

            // إعادة إنشاء توكن الجلسة للحماية
            $request->session()->regenerateToken();

            // إرجاع رد نجاح بصيغة JSON كما يتوقع الـ JavaScript
            return redirect()->route('login')->with('success', 'تم حذف حسابك بنجاح.');
        } catch (Throwable $e) {
            // في حالة حدوث أي خطأ، قم بتسجيله
            Log::error('فشل حذف الحساب للمستخدم ID ' . $user->id . ': ' . $e->getMessage());

            // إرجاع رد خطأ بصيغة JSON
            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ غير متوقع أثناء محاولة حذف الحساب.'
            ], 500); // Status 500 Internal Server Error
        }
    }
    public function showDeleteForm()
    {
        return view('Auth.delete-account');
    }
    public function forgetPassword()
    {
        return view('Auth.forgetPassword');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'يجب إدخال بريد إلكتروني صالح.',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'لم يتم العثور على مستخدم بهذا البريد الإلكتروني.']);
        }
        // إرسال رسالة نجاح
        return redirect()->back()->with('success', 'تم إرسال رابط استعادة كلمة المرور إلى بريدك الإلكتروني.');
    }

    public function shippingAgent()
    {
        return view('Auth.shipping-agent');
    }
}

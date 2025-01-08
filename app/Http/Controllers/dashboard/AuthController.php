<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function profile()
    {
        $user = auth()->user();
        $followersCount = $user->followers()->count();
        $followingCount = $user->followings()->count();
        $giftsCount = $user->gifts()->count();
        return view('dashboard.users.show', compact('user', 'followersCount', 'followingCount', 'giftsCount'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|unique:users,phone,' . auth()->id(),
            'address' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;
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
        // التحقق من صحة الإدخال
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
            if (auth()->user()->role === 'admin') {
                return redirect()->route('home.dashboard')->with('success', 'تم تسجيل الدخول بنجاح.');
            } else {
                return redirect()->route('home')->with('success', 'تم تسجيل الدخول بنجاح.');
            }
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
            'address' => 'required|max:255',
            'password' => 'required|min:6',
        ]);

        // تشفير كلمة المرور
        $data['password'] = bcrypt($data['password']);

        // إنشاء المستخدم
        $user = User::create($data);

        // تسجيل الدخول
        Auth::login($user);

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->back()->with('success', 'تم انشاء حسابك بنجاح');
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logout successful.');
    }
    public function deleteAccount()
    {
        $user = Auth::user();
        $user->delete();
        Auth::logout();
        return redirect()->route('login')->with('success', 'Account deleted successfully.');
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

}

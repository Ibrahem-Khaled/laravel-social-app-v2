<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $roles = ['admin', 'moderator', 'user', 'vip'];
        $selectedRole = $request->role ?? 'all';

        $users = User::query()
            ->where('role', '!=', 'website-data')
            ->when($selectedRole !== 'all', function ($query) use ($selectedRole) {
                return $query->where('role', $selectedRole);
            })
            ->when($request->search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('phone', 'like', "%$search%")
                        ->orWhere('username', 'like', "%$search%");
                });
            })
            ->latest()
            ->paginate(15);

        $usersCount = User::where('role', '!=', 'website-data')->count();
        $activeUsersCount = User::where('status', 'active')->where('role', '!=', 'website-data')->count();
        $adminsCount = User::where('role', 'admin')->count();

        return view('dashboard.users.index', compact(
            'users',
            'roles',
            'selectedRole',
            'usersCount',
            'activeUsersCount',
            'adminsCount'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,moderator,user,vip,website-data',
            'status' => 'required|in:active,inactive,banned',
            'gender' => 'nullable|in:male,female',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string|max:500',
            'birth_date' => 'nullable|date',
        ]);

        $userData = $request->except('password', 'avatar');
        $userData['password'] = Hash::make($request->password);
        $userData['uuid'] = (string) Str::uuid();

        if ($request->hasFile('avatar')) {
            $userData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        User::create($userData);

        return redirect()->route('users.index')->with('success', 'تم إضافة المستخدم بنجاح');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20|unique:users,phone,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,moderator,user,vip,website-data',
            'status' => 'required|in:active,inactive,banned',
            'gender' => 'nullable|in:male,female',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string|max:500',
            'birth_date' => 'nullable|date',
        ]);

        $userData = $request->except('password', 'avatar');

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $userData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($userData);

        return redirect()->route('users.index')->with('success', 'تم تحديث بيانات المستخدم بنجاح');
    }

    public function destroy(User $user)
    {
        // لا تسمح بحذف المستخدم الحالي
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'لا يمكنك حذف حسابك الخاص');
        }

        // حذف الصورة إذا كانت موجودة
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'تم حذف المستخدم بنجاح');
    }


    public function show(User $user)
    {
        // جلب عدد المتابعين والمتابعين
        $followersCount = $user->followers()->count();
        $followingCount = $user->followings()->count();
        $giftsCount = $user->gifts()->count();
        return view('dashboard.users.show', compact('user', 'followersCount', 'followingCount', 'giftsCount'));
    }

    public function toggleBan(Request $request, User $user)
    {
        $user->update([
            'status' => $user->status == 'active' ? 'banned' : 'active',
        ]);

        $message = $user->status == 'banned' ? 'تم حظر المستخدم بنجاح' : 'تم إلغاء حظر المستخدم بنجاح';
        return redirect()->route('users.index')->with('success', $message);
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        $users = User::where('name', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->limit(10)
            ->get(['id', 'name']); // استرجاع الحقول المطلوبة فقط

        return response()->json($users);
    }

    public function manageCoins(Request $request, User $user)
    {
        $request->validate([
            'coins' => 'required|integer|min:1',
            'action' => 'required|in:add,subtract',
        ]);

        if ($request->action === 'add') {
            $user->addCoins($request->coins);
            $message = "تم إضافة {$request->coins} نقطة للمستخدم بنجاح.";
        } elseif ($request->action === 'subtract') {
            if ($user->coins >= $request->coins) {
                $user->subtractCoins($request->coins);
                $message = "تم سحب {$request->coins} نقطة من المستخدم بنجاح.";
            } else {
                return redirect()->back()->withErrors(['error' => 'لا يمكن سحب نقاط أكثر من المتوفر.']);
            }
        }

        return redirect()->route('users.index')->with('success', $message);
    }

    public function toggleIsVerified(User $user)
    {
        $user->update([
            'is_verified' => !$user->is_verified,
        ]);

        $message = $user->is_verified ? 'تم توثيق المستخدم بنجاح' : 'تم حذف التوثيق من المستخدم بنجاح';
        return redirect()->route('users.index')->with('success', $message);
    }

    public function setLevel(Request $request, User $user)
    {
        $request->validate([
            'level_id' => 'required|exists:levels,id',
        ]);

        $user->update([
            'points' => Level::find($request->level_id)->points_required,
        ]);

        return redirect()->route('users.index')->with('success', 'تم تغيير المستوى للمستخدم بنجاح');
    }
}

<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('filter') && $request->filter != 'all') {
            switch ($request->filter) {
                case 'active':
                    $query->where('status', 'active');
                    break;
                case 'banned':
                    $query->where('status', 'banned');
                    break;
                case 'admin':
                    $query->where('role', 'admin');
                    break;
                case 'moderator':
                    $query->where('role', 'moderator');
                    break;
                case 'user':
                    $query->where('role', 'user');
                    break;
            }
        }
        // التحقق من وجود بحث
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('uuid', 'like', "%$search%")
                ->orWhere('name', 'like', "%$search%")
                ->orWhere('username', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('phone', 'like', "%$search%");
        }

        $users = $query->paginate(10);

        // إحصائيات
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $bannedUsers = User::where('status', 'banned')->count();
        $topCountry = User::select('country', \DB::raw('count(*) as count'))
            ->groupBy('country')
            ->orderByDesc('count')
            ->first();

        return view('dashboard.users.index', compact('users', 'totalUsers', 'activeUsers', 'bannedUsers', 'topCountry'));
    }


    public function show(User $user)
    {
        // جلب عدد المتابعين والمتابعين
        $followersCount = $user->followers()->count();
        $followingCount = $user->followings()->count();
        $giftsCount = $user->gifts()->count();
        return view('dashboard.users.show', compact('user', 'followersCount', 'followingCount', 'giftsCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'تم إضافة المستخدم بنجاح');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|unique:users,username,' . $user->id,
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('users.index')->with('success', 'تم تحديث المستخدم بنجاح');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'تم حذف المستخدم بنجاح');
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

}

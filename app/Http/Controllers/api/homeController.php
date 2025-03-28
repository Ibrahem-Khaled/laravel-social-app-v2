<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class homeController extends Controller
{

    public function deepSearch(Request $request)
    {
        $search = $request->input('search');

        // إذا كان البحث فارغاً يمكن إرجاع مصفوفة فارغة أو رسالة مناسبة
        if (empty($search)) {
            return response()->json([], 200);
        }

        // تهيئة الـ Query بشكل صحيح
        $query = User::query();

        // تطبيق شرط البحث
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%')
                ->orWhere('uuid', 'like', '%' . $search . '%')
                ->orWhere('username', 'like', '%' . $search . '%');
        });

        $users = $query->get();

        return response()->json($users, 200);
    }

    public function getHigherPointsFromUsersFollowers(Request $request)
    {
        $user = auth()->guard('api')->user();

        // استرجاع بيانات المستخدمين المتابعين وترتيبهم حسب نقاطهم بشكل تنازلي
        $followers = $user->followers()
            ->orderBy('users.coins', 'desc')
            ->get();

        return response()->json($followers);
    }


    public function getHigherPointsFromUsers()
    {
        // جلب أفضل 10 مستخدمين ترتيباً حسب النقاط من قاعدة البيانات
        $users = User::orderBy('coins', 'desc')
            ->limit(20)
            ->get();

        return response()->json($users);
    }

}

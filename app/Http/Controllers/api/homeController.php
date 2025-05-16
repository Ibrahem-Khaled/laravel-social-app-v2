<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VerificationRequest;
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

    public function submitVerification(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'front_id_image' => 'required|image|max:2048',
            'back_id_image' => 'required|image|max:2048',
        ]);

        $frontImagePath = $request->file('front_id_image')->store('verifications');
        $backImagePath = $request->file('back_id_image')->store('verifications');

        VerificationRequest::create([
            'user_id' => auth()->guard('api')->user()->id,
            'full_name' => $request->full_name,
            'front_id_image' => $frontImagePath,
            'back_id_image' => $backImagePath,
        ]);

        return response()->json(['message' => 'تم تقديم طلب التوثيق بنجاح.'], 200);
    }
}

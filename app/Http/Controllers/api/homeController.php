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

        // نبدأ الاستعلام بجلب المستخدمين مع آخر منشور لهم
        $query = User::with('latestPost');

        // إذا كانت هناك قيمة للبحث، نطبق الشروط
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                // 1. البحث في حقول المستخدم
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('uuid', 'like', '%' . $search . '%')
                    ->orWhere('username', 'like', '%' . $search . '%');

                // 2. البحث في المنشورات عبر whereHas
                $q->orWhereHas('posts', function ($postQuery) use ($search) {
                    $postQuery->where('title', 'like', '%' . $search . '%')
                        ->orWhere('content', 'like', '%' . $search . '%');
                });
            });
        }

        // اجلب النتائج
        $users = $query->get();

        return response()->json($users);
    }

}

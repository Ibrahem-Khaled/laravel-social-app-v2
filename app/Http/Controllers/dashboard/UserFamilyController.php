<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserFamliy as UserFamily;

class UserFamilyController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'famliy_id' => 'required|exists:famliys,id',
            'role' => 'nullable',
            'status' => 'required|in:pending,active,inactive',
        ]);

        UserFamily::create($request->all());

        return redirect()->back()->with('success', 'تم إضافة المستخدم إلى العائلة بنجاح.');
    }

    // تحديث حالة المستخدم في العائلة
    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => 'nullable',
            'status' => 'required|in:pending,active,inactive',
        ]);

        $userFamily = UserFamily::findOrFail($id);
        $userFamily->update($request->only(['role', 'status']));

        return redirect()->back()->with('success', 'تم تحديث حالة المستخدم بنجاح.');
    }

    // حذف مستخدم من العائلة
    public function destroy($id)
    {
        $userFamily = UserFamily::findOrFail($id);
        $userFamily->delete();
        return redirect()->back()->with('success', 'تم حذف المستخدم من العائلة بنجاح.');
    }

}

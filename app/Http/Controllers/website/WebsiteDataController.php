<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class WebsiteDataController extends Controller
{
    public function index()
    {
        // الحصول على بيانات الموقع أو إنشاء نموذج جديد إذا لم تكن موجودة
        $websiteData = User::where('role', 'website-data')->firstOrNew(['role' => 'website-data']);

        return view('dashboard.website-data.index', compact('websiteData'));
    }

    public function storeOrUpdate(Request $request)
    {
        // التحقق من وجود بيانات الموقع
        $websiteData = User::where('role', 'website-data')->first();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . ($websiteData ? $websiteData->id : 'NULL'),
            'phone' => 'nullable|unique:users,phone,' . ($websiteData ? $websiteData->id : 'NULL'),
            'avatar' => 'nullable|string',
            'bio' => 'nullable|string',
            'address' => 'nullable|string',
            'country' => 'nullable|string',
            'website' => 'nullable|url',
            'social_links' => 'nullable|json',
            'status' => 'required|in:active,inactive,banned',
            'gender' => 'nullable|in:male,female',
            'language' => 'required|string',
            'birth_date' => 'nullable|date',
            'settings' => 'nullable|json',
        ];

        // إذا كانت إضافة جديدة، نضيف شرطًا لكلمة المرور
        if (!$websiteData) {
            $rules['password'] = 'required|string|min:8';
        }

        $validated = $request->validate($rules);

        // إذا كانت بيانات الموقع موجودة، نقوم بالتحديث
        if ($websiteData) {
            $websiteData->update($validated);
            $message = 'تم تحديث بيانات الموقع بنجاح';
        }
        // إذا لم تكن موجودة، نقوم بإنشاء جديدة
        else {
            $validated['role'] = 'website-data';
            $validated['password'] = bcrypt($validated['password']);
            $websiteData = User::create($validated);
            $message = 'تم إضافة بيانات الموقع بنجاح';
        }

        return redirect()->route('website-data.index')
            ->with('success', $message);
    }
}

<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        $websiteData = User::where('role', 'website-data')->first();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore(optional($websiteData)->id)],
            'phone' => ['nullable', Rule::unique('users')->ignore(optional($websiteData)->id)],
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string',
            'address' => 'nullable|string',
            'country' => 'nullable|string',
            'website' => 'nullable|url',
            'social_links' => 'nullable|json',
            'gender' => 'nullable|in:male,female',
            'language' => 'required|string',
            'birth_date' => 'nullable|date',
            'settings' => 'nullable|json',
        ];
        $validated = $request->validate($rules);

        // التعامل مع الصورة إن وجدت
        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        if ($websiteData) {
            $websiteData->update($validated);
            $message = 'تم تحديث بيانات الموقع بنجاح';
        } else {
            $validated['role'] = 'website-data';
            $websiteData = User::create($validated);
            $message = 'تم إضافة بيانات الموقع بنجاح';
        }

        return redirect()->route('website-data.index')
            ->with('success', $message);
    }
}

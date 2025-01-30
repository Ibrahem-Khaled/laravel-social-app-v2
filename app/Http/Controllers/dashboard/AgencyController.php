<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Agency;
use Illuminate\Support\Facades\Storage;

class AgencyController extends Controller
{
    public function index()
    {
        $agencies = Agency::all();
        $users = User::all();
        return view('dashboard.agencies.index', compact('agencies', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|unique:agencies',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // تأكد من أن الملف صورة
        ]);

        $data = $request->all();

        // رفع الصورة إذا تم تقديمها
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('agencies', 'public'); // حفظ الصورة في مجلد public/agencies
            $data['image'] = $imagePath;
        }

        Agency::create($data);
        return redirect()->back()->with('success', 'تم إنشاء الوكالة بنجاح.');
    }
    public function show(Agency $agency)
    {
        $agencies = Agency::all();
        $users = User::all();
        return view('dashboard.agencies.show', compact('agency', 'agencies', 'users'));
    }
    public function update(Request $request, Agency $agency)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|unique:agencies,name,' . $agency->id,
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // تأكد من أن الملف صورة
        ]);

        $data = $request->all();

        // رفع الصورة إذا تم تقديمها
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($agency->image && Storage::disk('public')->exists($agency->image)) {
                Storage::disk('public')->delete($agency->image);
            }

            $imagePath = $request->file('image')->store('agencies', 'public'); // حفظ الصورة في مجلد public/agencies
            $data['image'] = $imagePath;
        }

        $agency->update($data);
        return redirect()->route('agencies.index')->with('success', 'تم تحديث الوكالة بنجاح.');
    }
    public function destroy(Agency $agency)
    {
        // حذف الصورة إذا كانت موجودة
        if ($agency->image && Storage::disk('public')->exists($agency->image)) {
            Storage::disk('public')->delete($agency->image);
        }

        $agency->delete();
        return redirect()->route('agencies.index')->with('success', 'تم حذف الوكالة بنجاح.');
    }
}

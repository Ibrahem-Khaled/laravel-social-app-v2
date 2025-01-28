<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Famliy as Family;

class FamilyController extends Controller
{
    // عرض جميع العائلات
    public function index()
    {
        $families = Family::with('user')->get();
        $users = User::all();
        return view('dashboard.families.index', compact('families', 'users'));
    }

    // حفظ العائلة الجديدة
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|unique:famliys',
            'description' => 'nullable',
            'image' => 'nullable|image',
        ]);

        $family = Family::create([
            'user_id' => $request->user_id, 
            'name' => $request->name,
            'description' => $request->description,
            'image' => $request->file('image') ? $request->file('image')->store('families') : null,
        ]);

        return redirect()->route('families.show', $family->id)->with('success', 'تم إنشاء العائلة بنجاح.');
    }

    // عرض تفاصيل العائلة والأعضاء
    public function show($id)
    {
        $family = Family::with('users')->findOrFail($id);
        $users = User::all();
        return view('dashboard.families.show', compact('family', 'users'));
    }


    // تحديث العائلة
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|unique:famliys,name,' . $id,
            'description' => 'nullable',
            'image' => 'nullable|image',
        ]);

        $family = Family::findOrFail($id);
        $family->update([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $request->file('image') ? $request->file('image')->store('families') : $family->image,
        ]);

        return redirect()->route('families.show', $family->id)->with('success', 'تم تحديث العائلة بنجاح.');
    }

    // حذف العائلة
    public function destroy($id)
    {
        $family = Family::findOrFail($id);
        $family->delete();
        return redirect()->route('families.index')->with('success', 'تم حذف العائلة بنجاح.');
    }
}

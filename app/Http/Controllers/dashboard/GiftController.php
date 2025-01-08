<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Gift;
use Illuminate\Http\Request;

class GiftController extends Controller
{
    public function index(Request $request)
    {
        $query = Gift::query();

        if ($request->has('search')) {
            $query->where('title', 'like', "%{$request->search}%")
                ->orWhere('description', 'like', "%{$request->search}%");
        }

        $gifts = $query->paginate(10);

        $totalGifts = Gift::count();
        $activeGifts = Gift::where('is_active', true)->count();
        $inactiveGifts = Gift::where('is_active', false)->count();
        $averagePrice = Gift::avg('price');
        $highestPricedGift = Gift::orderBy('price', 'desc')->first();
        $lowestPricedGift = Gift::orderBy('price', 'asc')->first();

        return view('dashboard.gifts.index', compact(
            'gifts',
            'totalGifts',
            'activeGifts',
            'inactiveGifts',
            'averagePrice',
            'highestPricedGift',
            'lowestPricedGift'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_animated' => 'nullable|file|mimes:gif,mp4|max:10240',
            'price' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
        ]);

        // معالجة رفع الصورة
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('gifts/images', 'public');
        }

        // معالجة رفع الملف المتحرك
        $animatedPath = null;
        if ($request->hasFile('is_animated')) {
            $animatedPath = $request->file('is_animated')->store('gifts/animated', 'public');
        }

        // إنشاء الهدية
        Gift::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'is_animated' => $animatedPath,
            'price' => $request->price,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('gifts.index')->with('success', 'تم إضافة الهدية بنجاح');
    }
    public function update(Request $request, Gift $gift)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_animated' => 'nullable|file|mimes:gif,mp4|max:10240',
            'price' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
        ]);

        // معالجة رفع الصورة
        $imagePath = $gift->image; // احتفظ بالصورة القديمة
        if ($request->hasFile('image')) {
            if ($gift->image) {
                \Storage::disk('public')->delete($gift->image); // حذف الصورة القديمة
            }
            $imagePath = $request->file('image')->store('gifts/images', 'public');
        }

        // معالجة رفع الملف المتحرك
        $animatedPath = $gift->is_animated; // احتفظ بالملف القديم
        if ($request->hasFile('is_animated')) {
            if ($gift->is_animated) {
                \Storage::disk('public')->delete($gift->is_animated); // حذف الملف القديم
            }
            $animatedPath = $request->file('is_animated')->store('gifts/animated', 'public');
        }

        // تحديث الهدية
        $gift->update([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'is_animated' => $animatedPath,
            'price' => $request->price,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('gifts.index')->with('success', 'تم تحديث بيانات الهدية بنجاح');
    }

    public function destroy(Gift $gift)
    {
        $gift->delete();

        return redirect()->route('gifts.index')->with('success', 'تم حذف الهدية بنجاح');
    }
}

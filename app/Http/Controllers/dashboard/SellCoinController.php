<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\SellCoins as SellCoin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SellCoinController extends Controller
{
    public function index(Request $request)
    {
        $selectedPlatform = $request->get('platform', 'all');
        $search = $request->get('search');

        $query = SellCoin::query();

        if ($selectedPlatform !== 'all') {
            $query->where('platform', $selectedPlatform);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('amount', 'like', "%$search%")
                    ->orWhere('price', 'like', "%$search%");
            });
        }

        $coins = $query->latest()->paginate(10);

        $platforms = ['mobile', 'web'];
        $totalCoins = SellCoin::count();
        $mobileCoins = SellCoin::where('platform', 'mobile')->count();
        $webCoins = SellCoin::where('platform', 'web')->count();
        $activeCoins = SellCoin::where('is_active', true)->count();

        return view('dashboard.sell-coins.index', compact(
            'coins',
            'platforms',
            'selectedPlatform',
            'totalCoins',
            'mobileCoins',
            'webCoins',
            'activeCoins'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'is_active' => 'boolean',
            'platform' => 'required|in:mobile,web'
        ]);

        $data = $request->except('icon');
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('coin-icons', 'public');
            $data['icon'] = $path;
        }

        SellCoin::create($data);

        return redirect()->route('sell-coins.index')
            ->with('success', 'تم إضافة عرض بيع العملات بنجاح');
    }

    public function update(Request $request, SellCoin $sellCoin)
    {
        $request->validate([
            'amount' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'is_active' => 'boolean',
            'platform' => 'required|in:mobile,web'
        ]);

        $data = $request->except('icon');
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('icon')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($sellCoin->icon) {
                Storage::disk('public')->delete($sellCoin->icon);
            }

            $path = $request->file('icon')->store('coin-icons', 'public');
            $data['icon'] = $path;
        }

        $sellCoin->update($data);

        return redirect()->route('sell-coins.index')
            ->with('success', 'تم تحديث عرض بيع العملات بنجاح');
    }

    public function destroy(SellCoin $sellCoin)
    {
        // حذف الصورة إذا كانت موجودة
        if ($sellCoin->icon) {
            Storage::disk('public')->delete($sellCoin->icon);
        }

        $sellCoin->delete();

        return redirect()->route('sell-coins.index')
            ->with('success', 'تم حذف عرض بيع العملات بنجاح');
    }
}

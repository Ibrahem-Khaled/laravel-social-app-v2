<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use App\Models\Game;


class GameController extends Controller
{
    public function index(Request $request)
    {
        // --- الإحصائيات ---
        $totalGames = Game::count();
        $activeGamesCount = Game::where('is_active', true)->count();
        $inactiveGamesCount = $totalGames - $activeGamesCount;
        $latestGame = Game::latest()->first();

        // --- بناء الاستعلام ---
        $query = Game::query();

        // 1. فلترة حسب الحالة (من التبويبات)
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // 2. فلترة حسب البحث
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 3. الترتيب والترقيم
        $games = $query->orderBy('position', 'asc')->paginate(10)->withQueryString();

        // متغير لتحديد التبويب النشط
        $selectedStatus = $request->status ?? 'all';

        return view('dashboard.games.index', compact(
            'games',
            'totalGames',
            'activeGamesCount',
            'inactiveGamesCount',
            'latestGame',
            'selectedStatus'
        ));
    }

    /**
     * تخزين لعبة جديدة من المودال
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'position' => 'required|integer',
        ]);

        $imagePath = $request->file('image')->store('games', 'public');

        Game::create([
            'name' => $request->name,
            'url' => $request->url,
            'image' => $imagePath,
            'position' => $request->position,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'تمت إضافة اللعبة بنجاح.');
    }

    /**
     * تحديث لعبة موجودة من المودال
     */
    public function update(Request $request, Game $game)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'position' => 'required|integer',
        ]);

        $imagePath = $game->image;
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($game->image);
            $imagePath = $request->file('image')->store('games', 'public');
        }

        $game->update([
            'name' => $request->name,
            'url' => $request->url,
            'image' => $imagePath,
            'position' => $request->position,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'تم تعديل اللعبة بنجاح.');
    }

    /**
     * حذف لعبة من المودال
     */
    public function destroy(Game $game)
    {
        Storage::disk('public')->delete($game->image);
        $game->delete();

        return back()->with('success', 'تم حذف اللعبة بنجاح.');
    }
}

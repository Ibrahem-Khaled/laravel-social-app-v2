<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function index(Request $request)
    {
        // إحصائيات المستويات
        $totalLevels = Level::count();
        $activeLevels = Level::where('is_active', true)->count();
        $inactiveLevels = Level::where('is_active', false)->count();
        $highestLevel = Level::max('level_number') ?? 0;

        // فلترة حسب الحالة
        $statusFilter = $request->input('status', 'all');
        $levels = Level::query()
            ->when($statusFilter === 'active', function ($query) {
                return $query->where('is_active', true);
            })
            ->when($statusFilter === 'inactive', function ($query) {
                return $query->where('is_active', false);
            });

        // البحث
        if ($request->has('search')) {
            $search = $request->input('search');
            $levels->where(function ($query) use ($search) {
                $query->where('level_number', 'like', "%$search%")
                    ->orWhere('name', 'like', "%$search%");
            });
        }

        // فلترة حسب النقاط
        if ($request->has('points_range')) {
            $range = $request->input('points_range');
            switch ($range) {
                case '0-100':
                    $levels->whereBetween('points_required', [0, 100]);
                    break;
                case '101-500':
                    $levels->whereBetween('points_required', [101, 500]);
                    break;
                case '501-1000':
                    $levels->whereBetween('points_required', [501, 1000]);
                    break;
                case '1001+':
                    $levels->where('points_required', '>', 1000);
                    break;
            }
        }

        // الترتيب
        $sort = $request->input('sort', 'level_number_asc');
        switch ($sort) {
            case 'level_number_desc':
                $levels->orderBy('level_number', 'desc');
                break;
            case 'points_asc':
                $levels->orderBy('points_required', 'asc');
                break;
            case 'points_desc':
                $levels->orderBy('points_required', 'desc');
                break;
            default:
                $levels->orderBy('level_number', 'asc');
        }

        // جلب عدد المستخدمين لكل مستوى
        $levels = $levels->paginate(10);

        return view('dashboard.levels.index', compact(
            'totalLevels',
            'activeLevels',
            'inactiveLevels',
            'highestLevel',
            'levels',
            'statusFilter'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'level_number' => 'required|integer|min:1|unique:levels,level_number',
            'points_required' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'color' => 'nullable|string|regex:/^#[a-f0-9]{6}$/i',
            'icon' => 'nullable|string',
        ]);

        Level::create($request->all());

        return redirect()->route('levels.index')
            ->with('success', 'تم إنشاء المستوى بنجاح.');
    }

    public function update(Request $request, Level $level)
    {
        $request->validate([
            'level_number' => 'required|integer|min:1|unique:levels,level_number,' . $level->id,
            'points_required' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'color' => 'nullable|string|regex:/^#[a-f0-9]{6}$/i',
            'icon' => 'nullable|string',
        ]);

        $level->update($request->all());

        return redirect()->route('levels.index')
            ->with('success', 'تم تحديث المستوى بنجاح.');
    }

    public function destroy(Level $level)
    {
        // هنا يمكنك إضافة منطق لنقل المستخدمين إلى مستوى افتراضي قبل الحذف
        $level->delete();

        return redirect()->route('levels.index')
            ->with('success', 'تم حذف المستوى بنجاح.');
    }
}

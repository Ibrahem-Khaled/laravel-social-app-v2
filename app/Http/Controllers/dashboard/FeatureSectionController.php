<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\FeatureSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class FeatureSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = FeatureSection::withCount('items')->latest();

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('slug', 'like', "%{$searchTerm}%")
                  ->orWhere('highlighted_title', 'like', "%{$searchTerm}%");
        }

        $sections = $query->paginate(8);

        // Statistics
        $totalSections = FeatureSection::count();
        $totalFeatures = DB::table('feature_items')->count();

        return view('dashboard.feature-sections.index', compact(
            'sections',
            'totalSections',
            'totalFeatures'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'slug' => 'required|string|alpha_dash|max:255|unique:feature_sections',
            'title_before_highlight' => 'required|string|max:255',
            'highlighted_title' => 'required|string|max:255',
            'title_after_highlight' => 'required|string|max:255',
            'description' => 'required|string',
            'button_text' => 'required|string|max:255',
            'button_url' => 'required|string|max:255',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_alt' => 'nullable|string|max:255',
            'items' => 'required|array|min:1',
            'items.*' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $imagePath = $request->file('image_path')->store('feature_sections', 'public');

            $section = FeatureSection::create([
                'slug' => $validatedData['slug'],
                'title_before_highlight' => $validatedData['title_before_highlight'],
                'highlighted_title' => $validatedData['highlighted_title'],
                'title_after_highlight' => $validatedData['title_after_highlight'],
                'description' => $validatedData['description'],
                'button_text' => $validatedData['button_text'],
                'button_url' => $validatedData['button_url'],
                'image_path' => $imagePath,
                'image_alt' => $validatedData['image_alt'],
            ]);

            foreach ($validatedData['items'] as $itemText) {
                $section->items()->create(['text' => $itemText]);
            }

            DB::commit();

            return redirect()->route('feature-sections.index')->with('success', 'تم إنشاء السكشن بنجاح.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'حدث خطأ ما: ' . $e->getMessage())->withInput();
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FeatureSection $featureSection)
    {
        $validatedData = $request->validate([
            'slug' => ['required', 'string', 'alpha_dash', 'max:255', Rule::unique('feature_sections')->ignore($featureSection->id)],
            'title_before_highlight' => 'required|string|max:255',
            'highlighted_title' => 'required|string|max:255',
            'title_after_highlight' => 'required|string|max:255',
            'description' => 'required|string',
            'button_text' => 'required|string|max:255',
            'button_url' => 'required|string|max:255',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'image_alt' => 'nullable|string|max:255',
            'items' => 'required|array|min:1',
            'items.*' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $updateData = $request->except(['_token', '_method', 'image_path', 'items']);

            if ($request->hasFile('image_path')) {
                if ($featureSection->image_path) {
                    Storage::disk('public')->delete($featureSection->image_path);
                }
                $updateData['image_path'] = $request->file('image_path')->store('feature_sections', 'public');
            }

            $featureSection->update($updateData);

            // Sync items (delete old ones, add new ones)
            $featureSection->items()->delete();
            foreach ($validatedData['items'] as $itemText) {
                $featureSection->items()->create(['text' => $itemText]);
            }

            DB::commit();

            return redirect()->route('feature-sections.index')->with('success', 'تم تحديث السكشن بنجاح.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'حدث خطأ ما: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FeatureSection $featureSection)
    {
        try {
            if ($featureSection->image_path) {
                Storage::disk('public')->delete($featureSection->image_path);
            }
            $featureSection->delete(); // Cascade delete will handle items
            return redirect()->route('feature-sections.index')->with('success', 'تم حذف السكشن بنجاح.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء الحذف: ' . $e->getMessage());
        }
    }
}

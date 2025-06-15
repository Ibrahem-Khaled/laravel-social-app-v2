<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Models\FAQ;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    public function index(Request $request)
    {
        $selectedCategory = $request->input('category', 'all');
        $search = $request->input('search');

        $faqs = FAQ::with('user')
            ->when($selectedCategory !== 'all', function ($query) use ($selectedCategory) {
                return $query->where('category', $selectedCategory);
            })
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('question', 'like', "%$search%")
                        ->orWhere('answer', 'like', "%$search%");
                });
            })
            ->latest()
            ->paginate(10);

        $categories = FAQ::$categories;
        $totalFaqs = FAQ::count();
        $activeFaqs = FAQ::active()->count();
        $featuredFaqs = FAQ::featured()->count();
        $mostViewed = FAQ::orderBy('views', 'desc')->take(5)->get();

        return view('dashboard.website-data.FAQ', compact(
            'faqs',
            'categories',
            'selectedCategory',
            'totalFaqs',
            'activeFaqs',
            'featuredFaqs',
            'mostViewed'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category' => 'required|in:' . implode(',', array_keys(FAQ::$categories)),
            // 'is_featured' => 'nullable|boolean',
            // 'is_active' => 'nullable|boolean',
        ]);

        FAQ::create([
            'question' => $request->question,
            'answer' => $request->answer,
            'category' => $request->category,
            // 'is_featured' => $request->boolean('is_featured'),
            // 'is_active' => $request->boolean('is_active'),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('faqs.index')->with('success', 'تمت إضافة السؤال بنجاح');
    }

    public function update(Request $request, FAQ $faq)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category' => 'required|in:' . implode(',', array_keys(FAQ::$categories)),
            // 'is_featured' => 'nullable|boolean',
            // 'is_active' => 'nullable|boolean',
        ]);

        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
            'category' => $request->category,
            // 'is_featured' => $request->boolean('is_featured'),
            // 'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('faqs.index')->with('success', 'تم تحديث السؤال بنجاح');
    }

    public function destroy(FAQ $faq)
    {
        $faq->delete();
        return redirect()->route('faqs.index')->with('success', 'تم حذف السؤال بنجاح');
    }

    public function toggleStatus(FAQ $faq)
    {
        $faq->update(['is_active' => !$faq->is_active]);
        return back()->with('success', 'تم تغيير حالة السؤال بنجاح');
    }

    public function toggleFeatured(FAQ $faq)
    {
        $faq->update(['is_featured' => !$faq->is_featured]);
        return back()->with('success', 'تم تغيير حالة التميز بنجاح');
    }
}

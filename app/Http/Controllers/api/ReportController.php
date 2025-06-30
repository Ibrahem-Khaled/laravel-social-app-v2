<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReportRequest;
use App\Http\Resources\ReportResource;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReportController extends Controller
{
    /**
     * عرض قائمة بالبلاغات.
     * ملاحظة: هذه الدالة يجب أن تكون محمية للمشرفين فقط.
     */
    public function index()
    {
        // يمكنك إضافة صلاحيات هنا، على سبيل المثال:
        // $this->authorize('viewAny', Report::class);

        $reports = Report::with('user:id,name')->latest()->paginate(20);
        return ReportResource::collection($reports);
    }

    /**
     * تخزين بلاغ جديد في قاعدة البيانات.
     */
    public function store(StoreReportRequest $request)
    {
        // الحصول على البيانات التي تم التحقق منها فقط
        $validatedData = $request->validated();
        $userId = auth()->guard('api')->id();

        // التحقق مما إذا كان المستخدم قد أبلغ عن هذا المحتوى من قبل
        $existingReport = Report::where('user_id', $userId)
            ->where('related_id', $validatedData['related_id'])
            ->where('related_type', $validatedData['related_type'])
            ->first();

        if ($existingReport) {
            return response()->json(['message' => 'لقد قمت بالإبلاغ عن هذا المحتوى مسبقًا.'], 409);
        }

        // --- الطريقة الجديدة والأكثر أمانًا لإنشاء البلاغ ---

        // 1. إنشاء نسخة جديدة من موديل Report بالبيانات التي تم التحقق منها
        $report = new Report($validatedData);

        // 2. تعيين user_id بشكل مباشر من المستخدم المصادق عليه
        $report->user_id = $userId;

        // 3. حفظ الموديل في قاعدة البيانات
        $report->save();

        // ----------------------------------------------------

        return (new ReportResource($report))
            ->additional(['message' => 'تم استلام بلاغك بنجاح، شكرًا لك.'])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * عرض بلاغ محدد.
     * ملاحظة: هذه الدالة يجب أن تكون محمية للمشرفين فقط.
     */
    public function show(Report $report)
    {
        // $this->authorize('view', $report);
        $report->load('user:id,name,avatar');
        return new ReportResource($report);
    }

    /**
     * تحديث حالة البلاغ (على سبيل المثال، إخفاؤه بعد المراجعة).
     * ملاحظة: هذه الدالة يجب أن تكون محمية للمشرفين فقط.
     */
    public function update(Request $request, Report $report)
    {
        // $this->authorize('update', $report);

        $request->validate(['is_hidden' => 'required|boolean']);

        $report->update(['is_hidden' => $request->boolean('is_hidden')]);

        return (new ReportResource($report))
            ->additional(['message' => 'تم تحديث حالة البلاغ بنجاح.']);
    }

    /**
     * حذف بلاغ.
     * ملاحظة: هذه الدالة يجب أن تكون محمية للمشرفين فقط.
     */
    public function destroy(Report $report)
    {
        // $this->authorize('delete', $report);

        $report->delete();

        return response()->json(['message' => 'تم حذف البلاغ بنجاح.'], Response::HTTP_OK);
    }
}

<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\CallLog;
use Illuminate\Http\Request;

class CallLogController extends Controller
{
    public function index(Request $request)
    {
        // 1. جلب المستخدم الحالي من Guard 'api'
        $user = $request->user('api');

        $callLogs = $user
            ->allCallLogs()
            ->orderByDesc('start_time')
            ->get();

        // رد JSON شفاف يحتوي على بيانات المكالمات كاملة
        return response()->json([
            'status' => 'success',
            'call_logs' => $callLogs,
        ], 200);
    }
    public function store(Request $request)
    {
        // تخزين سجل مكالمة جديد
        $data = $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'call_type' => 'required|in:audio,video',
        ]);

        $data['sender_id'] = auth()->guard('api')->user()->id;
        $data['start_time'] = $data['start_time'] ?? now();

        $callLog = CallLog::create($data);

        return response()->json($callLog, 201);
    }

    public function update(CallLog $callLog)
    {
        // تحديث سجل مكالمة
        $data = request()->validate([
            'call_status' => 'required|in:missed,answered,declined',
        ]);
        $data['end_time'] = now();
        $data['call_duration'] = now()->diffInSeconds($callLog->start_time);
        $callLog->update($data);

        return response()->json($callLog);
    }

    public function destroy(CallLog $callLog)
    {
        // حذف سجل مكالمة
        $callLog->delete();
        return response()->json(['message' => 'تم حذف سجل المكالمة بنجاح']);
    }
}

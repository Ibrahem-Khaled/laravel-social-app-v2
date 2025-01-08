<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VerificationRequest;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'front_id_image' => 'required|image|max:2048',
            'back_id_image' => 'required|image|max:2048',
        ]);

        $frontImagePath = $request->file('front_id_image')->store('verifications');
        $backImagePath = $request->file('back_id_image')->store('verifications');

        VerificationRequest::create([
            'user_id' => auth()->id(),
            'full_name' => $request->full_name,
            'front_id_image' => $frontImagePath,
            'back_id_image' => $backImagePath,
        ]);

        return redirect()->back()->with('success', 'تم تقديم طلب التوثيق بنجاح.');
    }

    public function index()
    {
        $verificationRequests = VerificationRequest::with('user')->latest()->paginate(10);

        return view('dashboard.verifications.index', compact('verificationRequests'));
    }

    public function approve(VerificationRequest $verificationRequest)
    {
        $verificationRequest->update(['status' => 'approved']);
        $user = User::find($verificationRequest->user_id);
        $user->update([
            'is_verified' => true
        ]);
        return redirect()->back()->with('success', 'تم قبول طلب التوثيق.');
    }

    public function reject(Request $request, VerificationRequest $verificationRequest)
    {
        $request->validate(['rejection_reason' => 'required|string']);

        $verificationRequest->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->back()->with('success', 'تم رفض طلب التوثيق.');
    }
}

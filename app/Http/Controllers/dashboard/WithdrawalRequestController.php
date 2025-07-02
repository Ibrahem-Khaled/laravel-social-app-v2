<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\WithdrawalRequest;
use Illuminate\Http\Request;

class WithdrawalRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Base query with eager loading for performance
        $query = WithdrawalRequest::with(['user', 'wallet'])->latest();

        // Handle search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('amount', 'like', "%{$searchTerm}%")
                    ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('name', 'like', "%{$searchTerm}%")
                            ->orWhere('email', 'like', "%{$searchTerm}%");
                    })
                    ->orWhereHas('wallet', function ($walletQuery) use ($searchTerm) {
                        $walletQuery->where('wallet_name', 'like', "%{$searchTerm}%");
                    });
            });
        }

        // Handle status filtering
        if ($request->filled('status') && in_array($request->status, ['pending', 'approved', 'completed', 'rejected'])) {
            $query->where('status', $request->status);
        }

        // Paginate the results
        $withdrawalRequests = $query->paginate(10)->withQueryString();

        // Calculate statistics
        $stats = [
            'total'     => WithdrawalRequest::count(),
            'pending'   => WithdrawalRequest::where('status', 'pending')->count(),
            'approved'  => WithdrawalRequest::whereIn('status', ['approved', 'completed'])->count(),
            'rejected'  => WithdrawalRequest::where('status', 'rejected')->count(),
        ];

        return view('dashboard.withdrawal-requests.index', compact('withdrawalRequests', 'stats'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WithdrawalRequest $withdrawalRequest)
    {
        $request->validate([
            'status' => 'required|in:approved,completed,rejected',
            'rejection_reason' => 'required_if:status,rejected|string|max:1000',
        ]);

        $withdrawalRequest->status = $request->status;
        $withdrawalRequest->rejection_reason = $request->status === 'rejected' ? $request->rejection_reason : null;
        $withdrawalRequest->processed_at = now();
        $withdrawalRequest->save();

        // Here you can add logic to notify the user
        // For example: event(new WithdrawalRequestUpdated($withdrawalRequest));

        return redirect()->route('withdrawal-requests.index')
            ->with('success', 'تم تحديث حالة الطلب بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WithdrawalRequest $withdrawalRequest)
    {
        $withdrawalRequest->delete();

        return redirect()->route('withdrawal-requests.index')
            ->with('success', 'تم حذف طلب السحب بنجاح.');
    }
}

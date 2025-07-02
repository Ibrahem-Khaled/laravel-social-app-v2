<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreWalletRequest;
use App\Http\Requests\Api\StoreWithdrawalRequest;
use App\Http\Resources\WalletResource;
use App\Http\Resources\WithdrawalRequestResource;
use App\Models\Wallet;
use Illuminate\Http\Request;

class FinancialController extends Controller
{
    public function listWallets()
    {
        $wallets = auth()->guard('api')->user()->wallets()->latest()->get();
        return WalletResource::collection($wallets);
    }

    /**
     * إنشاء محفظة جديدة.
     * Create a new wallet.
     */
    public function createWallet(StoreWalletRequest $request)
    {
        $wallet = auth()->guard('api')->user()->wallets()->create($request->validated());
        return new WalletResource($wallet);
    }

    /**
     * عرض تفاصيل محفظة معينة.
     * Show details of a specific wallet.
     */
    public function showWallet(Wallet $wallet)
    {
        // Authorize that the user owns this wallet
        $this->authorize('view', $wallet);
        return new WalletResource($wallet);
    }

    /**
     * حذف محفظة.
     * Delete a wallet.
     */
    public function deleteWallet(Wallet $wallet)
    {
        // Authorize that the user can delete this wallet
        $this->authorize('delete', $wallet);
        $wallet->delete();
        return response()->json(['message' => 'Wallet deleted successfully.'], 200);
    }


    //======================================================================
    // Withdrawal Request Methods
    //======================================================================

    /**
     * قائمة بجميع طلبات السحب الخاصة بالمستخدم.
     * List all withdrawal requests for the authenticated user.
     */
    public function listWithdrawals(Request $request)
    {
        $query = auth()->guard('api')->user()->withdrawalRequests()->with('wallet');

        // Optional: Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $requests = $query->latest()->paginate(15);
        return WithdrawalRequestResource::collection($requests);
    }

    /**
     * تقديم طلب سحب جديد.
     * Submit a new withdrawal request.
     */
    public function createWithdrawal(StoreWithdrawalRequest $request)
    {
        // The validation logic is handled in StoreWithdrawalRequest
        $withdrawalRequest = auth()->guard('api')->user()->withdrawalRequests()->create($request->validated());

        return new WithdrawalRequestResource($withdrawalRequest);
    }
}

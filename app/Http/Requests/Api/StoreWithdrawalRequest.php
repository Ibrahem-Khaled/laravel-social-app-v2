<?php

namespace App\Http\Requests\Api;

use App\Models\Wallet;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StoreWithdrawalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Authorization is handled by the 'auth:api' middleware.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            // 'wallet_id' must be required and must exist in the 'wallets' table.
            // Crucially, it must also belong to the currently authenticated user.
            'wallet_id' => [
                'required',
                Rule::exists('wallets', 'id')->where('user_id', auth('api')->id()),
            ],

            // 'amount' must be required, numeric, and greater than 0.
            'amount' => 'required|numeric|gt:0',

            // 'password' validation is the most critical part.
            'password' => [
                'required',
                'string',
                // We use a custom closure for complex password validation logic.
                function ($attribute, $value, $fail) {
                    // Find the wallet specified in the request.
                    $wallet = Wallet::find($this->input('wallet_id'));

                    // This check is redundant due to the 'exists' rule above, but it's good practice.
                    if (!$wallet) {
                        return;
                    }

                    // SCENARIO 1: The selected wallet has its own specific password.
                    if ($wallet->password) {
                        if (!Hash::check($value, $wallet->password)) {
                            $fail('كلمة مرور المحفظة المحددة غير صحيحة.');
                        }
                        return; // Password is correct, validation passes.
                    }

                    // SCENARIO 2: The selected wallet does NOT have its own password.
                    // We must check against the password of the user's first-ever created wallet that has a password.
                    $primaryWalletWithPassword = auth('api')->user()
                        ->wallets()
                        ->whereNotNull('password')
                        ->orderBy('created_at', 'asc')
                        ->first();

                    if ($primaryWalletWithPassword && Hash::check($value, $primaryWalletWithPassword->password)) {
                        // Password matches the primary wallet's password, validation passes.
                        return;
                    }

                    // If we reach here, it means no valid password was found.
                    $fail('كلمة مرور السحب غير صحيحة.');
                },
            ],
        ];
    }
}

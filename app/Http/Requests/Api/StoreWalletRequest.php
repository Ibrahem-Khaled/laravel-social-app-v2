<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreWalletRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * We set this to true because the authorization is handled by the 'auth:api'
     * middleware on the route/controller level.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * Here we define all the rules for creating a new wallet.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            // 'wallet_name' is required, must be a string, and cannot exceed 255 characters.
            'wallet_name' => 'required|string|max:255',

            // 'wallet_type' is required and must be one of the specified values.
            // You can add more types like 'paypal', 'payoneer', etc.
            'wallet_type' => 'required|string',

            // 'wallet_details' is required and must be an array.
            'wallet_details' => 'required|array',

            // --- Conditional Validation based on wallet_type ---
            // These rules apply only if the 'wallet_type' matches.

            // If wallet_type is 'bank_account', then 'iban' and 'account_holder' are required.
            'wallet_details.iban' => 'required_if:wallet_type,bank_account|string|max:34',
            'wallet_details.account_holder' => 'required_if:wallet_type,bank_account|string|max:255',
            'wallet_details.swift_code' => 'nullable|string|max:11',

            // If wallet_type is 'e_wallet', then 'phone' is required.
            'wallet_details.phone' => 'required_if:wallet_type,e_wallet|string|max:20',
            'wallet_details.network' => 'nullable|string|max:50', // e.g., Vodafone, Orange

            // If wallet_type is 'crypto', then 'address' and 'network' are required.
            'wallet_details.address' => 'required_if:wallet_type,crypto|string|max:255',
            'wallet_details.crypto_network' => 'required_if:wallet_type,crypto|string|max:50', // e.g., BTC, ETH, TRC20

            // 'password' is optional (nullable). If provided, it must be a string,
            // have a minimum of 6 characters, and match the 'password_confirmation' field.
            'password' => 'nullable|string|min:6|confirmed',

            // 'is_default' is optional and must be a boolean (true/false, 1/0).
            'is_default' => 'nullable|boolean',
        ];
    }
}
